<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employe;
use App\Models\Position;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\CursorPaginator;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const COUNT_EMPLOYES = '5'; // number of working hours
    const XML_FILE_PATH = '../resources/files/employes.xml';

    protected function getEmployesPage(Request $request)
    {
        $page = $request->get('page') ?? '1';
        $count = $request->get('count') ?? self::COUNT_EMPLOYES;

        //var_dump($page);
        //var_dump($count);

        $employes = [];

        $employes = Employe::selectRaw('employes.id, employes.full_name, employes.birthday, employes.department_id, employes.position_id, employes.rate_type, employes.rate')
            ->with([
                'department' => function($q) {
                    $q->select(['id', 'name']);
                },
                'position' => function($q) {
                    $q->select(['id', 'name']);
                },
            ])
            ->orderByDesc('full_name')
            ->paginate($count);

        //dd($employes);

        //echo route('department-page', ['department' => 1, 'page' => 3]);

        return view('pages.employes', compact('employes'));
    }

    protected function getDepartmentPage(Request $request, $departmentId)
    {
        $department = Department::selectRaw('departments.id, departments.name')->whereId($departmentId)->first();
        if (empty($department)) {
            abort(404);
        }

        $count = $request->get('count') ?? self::COUNT_EMPLOYES;

        $employes = Employe::selectRaw('employes.id, employes.full_name, employes.birthday, employes.department_id, employes.position_id, employes.rate_type, employes.rate')
            ->whereDepartmentId($departmentId)
            ->with([
                'department' => function($q) {
                    $q->select(['id', 'name']);
                    //$q->where('id', 'like', '1');
                },
                'position' => function($q) {
                    $q->select(['id', 'name']);
                },
            ])
            ->orderByDesc('full_name')
            ->paginate($count);



        //var_dump($department);
        //dd($department);

        return view('pages.department', compact('employes', 'department'));
    }
}
