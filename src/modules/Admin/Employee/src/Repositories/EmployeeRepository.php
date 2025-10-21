<?php

namespace Modules\Admin\Employee\src\Repositories;

use Modules\Admin\Employee\src\Repositories\EmployeeRepositoryInterface;
use App\Repositories\BaseRepository;
use Modules\Admin\Employee\src\Models\Employee;
use Modules\Admin\Employee\src\Models\EmployeeDetails;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\isEmpty;
use Modules\Admin\Employee\src\Models\Position;
use Modules\Admin\Employee\src\Models\Grant;
use Modules\Admin\Employee\src\Models\Contrast;
use Modules\Admin\Employee\src\Models\WorkShifts;
use Modules\Admin\Employee\src\Models\Department;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface {
    public function getModel()
    {
        return Employee::class;
    }
    public function getModelDetail(){
        return EmployeeDetails::class;
    }
    public function getDetailBase($employee) {
        $host = env('APP_URL');
        $data = [
            'id' => $employee->id,
            'code' => $employee->code,
            'name' => $employee->name,
            'email' => $employee->email,
            'phone' => $employee->phone,
            'img' => $host.$employee->img,
            'address' => str_replace("\n", ' ', $employee->address),
            'gender' => $employee->gender,
            'date_birth' => $employee->detail->date_birth,
            'date_start_work' => $employee->detail->date_start_work,
            'salary' => $employee->detail->salary,
            'diploma' => $employee->detail->diploma,
            'status' => $employee->detail->status,
            'date_sign_contrast' => $employee->detail->date_sign_contrast,
            'date_effect_contrast' => $employee->detail->date_effect_contrast,
            'date_end_contrast' => $employee->detail->date_end_contrast,
            'position' => $employee->detail->position->name, // $employee->detail->position->name
            'work_shift' => $employee->detail->workShifts->name,
            'department' => $employee->detail->department->name,
            'grant' => $employee->detail->grant->name,
            'contrast' => $employee->detail->contrast->name,
        ];
        return $data;
    }
    public function getListEmployee($start, $end)
    {
        $count = $end - $start;
        $employees = $this->model::with([
            'detail' => function($query) {
                $query->select('employee_id', 'position_id');
            },
            'detail.position' => function($query) {
                $query->select('id', 'code', 'name');
            },

        ])->select('id', 'code', 'name', 'phone', 'img')
        ->latest()
        ->skip($start)->take($count)->get();

        if ($employees->isEmpty()) {
            throw new \Exception("Không tìm thấy nhân viên trong khoảng yêu cầu", 404);
        }
        $host = env('APP_URL');
        $employees = $employees->map(function($employee) use($host){
            return [
                'id' => $employee->id,
                'code' => $employee->code,
                'name' => $employee->name,
                'phone' => $employee->phone,
                'img' => $host.$employee->img,
                'position' => $employee->detail->position->name // nếu cần quan hệ detail
            ];
        });
        return $employees;
    }

    public function getDetailEmployee($id) {
        $employee_key = "employee_$id";
        return Cache::tags(['employees', "employee_id_$id"])->remember($employee_key, 600, function() use($id){
            $employee = $this->model::with('detail')->find($id);
            if (!$employee) {
                throw new \Exception("Không tìm thấy nhân viên phù hợp yêu cầu", 404);
            }
            return $this->getDetailBase($employee);
        });
    }

    public function deleteEmployee($ids) {
        return DB::transaction(function () use ($ids) {
            if (is_array($ids)) {
                $employees = $this->model::whereIn('id', $ids)->whereNull('deleted_at');
                if(!$employees->exists()) {
                    throw new \Exception('Không tìm thấy nhân viên hợp lệ để xoá.', 404);
                }
                //Cache::tags(['employees'])->flush();
                Cache::tags(array_merge(array_map(fn($id) => "employee_id_$id", $ids)))->flush();
                $employees->delete();
                $this->modelDetail::whereIn('employee_id', $ids)->delete();
                // foreach ($ids as $id) {
                //     Cache::tags(['employees', "id_$id"])->flush();
                // }
            }
            else {
                $employee = $this->model::with('detail')->find($ids);
                if(!$employee) {
                    throw new \Exception('Không tìm thấy nhân viên hợp lệ để xoá.', 404);
                }
                if ($employee->detail) {
                    $employee->detail()->delete();
                }
                $employee->delete();
                Cache::tags(["employee_id_$ids"])->flush();
            }

        });
    }

    public function forceDelete($id) {
        $employee = $this->model::with('detail')->onlyTrashed()->find($id);
        if(!$employee) {
            throw new \Exception('Không tìm thấy nhân viên', 404);
        }
        if ($employee->detail) {
            $employee->detail()->forceDelete();
            $employee->forceDelete();
        }
    }

    public function getListForceDelete($start, $end) {
        $count = $end - $start;
        $employees = $this->model::with([
            'detail' => function($query) {
                $query->select('employee_id', 'position_id');
            },
            'detail.position' => function($query) {
                $query->select('id', 'code', 'name');
            }
        ])->select('id', 'code', 'name', 'phone', 'img', 'deleted_at')->onlyTrashed()
        ->latest()
        ->skip($start)->take($count)->get();

        if ($employees->isEmpty()) {
            throw new \Exception("Không tìm thấy nhân viên trong khoảng yêu cầu", 404);
        }

        $host = env('APP_URL');
        $employees =  $employees->map(function($employee) use($host) {
            return [
                'id' => $employee->id,
                'code' => $employee->code,
                'name' => $employee->name,
                'img' => $host.$employee->img,
                'phone' => $employee->phone,
                'position' => optional($employee->detail->position)->name,
                'deleted_at' => Carbon::parse($employee->deleted_at)->format('Y-m-d H:i:s')
            ];
        });
        return $employees;
    }

    public function recoverEmployeeDelete($id) {
        $employee = $this->model::with([
            'detail' => function ($query) {
                $query->select('employee_id', 'position_id');
            },
            'detail.position' => function ($query) {
                $query->select('id', 'name');
            }
        ])
        ->select('id', 'code', 'name', 'phone', 'img', 'deleted_at')
        ->onlyTrashed()
        ->find($id);

        if (!$employee) {
            throw new \Exception("Không tìm thấy nhân viên phù hợp yêu cầu", 404);
        }
        if($employee->detail) {
            $employee->detail()->restore();
            $employee->restore();
        }
        else {
            throw new \Exception("Phục hồi nhân viên không thành công", 400);
        }
        $host = env('APP_URL');
        $response = [
            'id' => $employee->id,
            'code' => $employee->code,
            'name' => $employee->name,
            'img' => $host.$employee->img,
            'phone' => $employee->phone,
            'position' => optional($employee->detail->position)->name,
        ];
        return $response;
    }


    public function createEmployee($data) {
        return DB::transaction(function () use ($data) {
            $created = $employee = $this->model->create([
                'code'    => $data['code'],
                'name'    => $data['name'],
                'email'   => $data['email'],
                'phone'   => $data['phone'],
                'img'     => $data['img'] ?? '/storage/images/img_employee/img_employee.jpg',
                'address' => $data['address'],
                'gender'  => $data['gender'],
                'password'       => Hash::make($data['password']),
            ]);
            $createdDetail = $employee->detail()->create([
                'employee_id'    => $employee->id,
                'date_birth'     => $data['date_birth'],
                'date_start_work'=> $data['date_start_work'],
                'salary'         => $data['salary'],
                'diploma'        => $data['diploma'] ?? null,
                'status'         => $data['status'] ?? null,
                'contrast_id'    => $data['contrast_id'],
                'work_shift_id'  => $data['work_shift_id'],
                'position_id'    => $data['position_id'],
                'department_id'  => $data['department_id'],
                'grant_id'       => $data['grant_id']
            ]);
            if (!$created || !$createdDetail) {
                throw new \Exception("Thêm nhân viên không thành công", 400);
            }
            $employeeData = $this->getDetailBase($employee);
            Cache::tags(['employees', "employee_id_{$employee->id}"])
                ->put("employee_{$employee->id}", $employeeData, 600);
            return $employeeData;
        });
    }

    public function editEmployee($id, $data) {
        return DB::transaction(function () use ($id, $data) {
            $employee = $this->model::with('detail')->find($id);
            if(!$employee) {
                throw new \Exception("Không tìm thấy nhân viên phù hợp", 404);
            }
            $fieldEmployee = ['code', 'name', 'email', 'phone', 'img', 'address', 'gender'];
            $emp = [];
            foreach ($fieldEmployee as $field) {
                if (!empty($data[$field])) {
                    $emp[$field] = $data[$field];
                }
            }

            $fieldEmployeeDetail = ['employee_id', 'date_birth', 'date_start_work', 'salary', 'diploma', 'status',
            'password', 'contrast_id', 'work_shift_id', 'position_id', 'department_id', 'grant_id'];

            $empDetail = [];
            foreach ($fieldEmployeeDetail as $field) {
                if (!empty($data[$field])) {
                    $empDetail[$field] = $data[$field];
                }
            }

            if (!empty($empDetail['password'])) {
                $empDetail['password'] = Hash::make($empDetail['password']);
            }

            $updated = $employee->update($emp);
            $updatedDetail = $employee->detail()->update($empDetail);


            if (!$updated || !$updatedDetail) {
                throw new \Exception("Cập nhập thông tin thất bại", 400);
            }

            $employee->load([
                'detail.position',
                'detail.workShifts',
                'detail.department',
                'detail.grant',
                'detail.contrast',
            ]);
            // Xoá cache cũ
            Cache::tags(["employee_id_$id"])->flush();

            // Lưu cache mới
            Cache::tags(['employees', "employee_id_$id"])->put("employee_$id", $this->getDetailBase($employee), 600);
            return $this->getDetailBase($employee);

        });
    }

    public function findEmployee($page, $find, $count) {
        $host = env('APP_URL');
        $employees = $this->model::where('name', 'like', '%' . $find . '%')
            ->select('id', 'code', 'name', 'img', 'phone')
            ->with('detail.position') // eager load detail và position để tránh N+1
            ->paginate($count);
        if ($employees->total() === 0) {
            throw new \Exception("Không tìm thấy nhân viên phù hợp", 404);
        }
        $employees = $employees->getCollection()->map(function($employee) use($host) {
            return [
                'id'       => $employee->id,
                'code'     => $employee->code,
                'name'     => $employee->name,
                'img'      => $employee->img ? $host . $employee->img : null,
                'phone'    => $employee->phone,
                'position' => $employee->detail && $employee->detail->position
                              ? $employee->detail->position->name
                              : null,
            ];
        });
        return $employees;
    }

    public function getPosition() {
        $positions = Position::select('id', 'name', 'code', 'status', 'description')->get();
        return $positions;
    }

    public function getGrants() {
        $grants = Grant::select('id', 'name', 'code', 'money', 'type', 'status', 'description')->get();
        return $grants;
    }

    public function getContrasts() {
        $contrasts = Contrast::select('id', 'name', 'code', 'status', 'description')->get();
        return $contrasts;
    }

    public function getWorkShifts() {
        $workShifts = WorkShifts::select('id', 'name', 'code', 'start_hour', 'end_hour' ,'duration', 'status', 'description')->get();
        return $workShifts;
    }

    public function getDepartments() {
        $department = Department::select('id', 'name', 'code', 'status', 'description')->get();
        return $department;
    }
}
