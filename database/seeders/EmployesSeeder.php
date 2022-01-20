<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employe;
use App\Models\Position;
use Illuminate\Database\Seeder;

class EmployesSeeder extends Seeder
{
    const XML_FILE_PATH = '/files/employes.xml';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $xmlDataString = file_get_contents(public_path(self::XML_FILE_PATH));
        $xmlObject = simplexml_load_string($xmlDataString);

        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true);

        if (!empty($phpDataArray)) {

            foreach ($phpDataArray['Employe'] as $employe) {

                $dataArray = [];

                foreach ($employe as $key => $value) {
                    switch ($key) {
                        case 'department':
                            $department = Department::selectRaw('departments.id, departments.name')->whereName($value)->first();
                            if (empty($department['name'])) {
                                $department = Department::updateOrCreate([
                                    'name' => $value,
                                ]);
                                $department->save();
                            }
                            $dataArray['department_id'] = $department->id;

                            break;
                        case 'position':
                            $position = Position::selectRaw('positions.id, positions.name')->whereName($value)->first();
                            if (empty($position['name'])) {
                                $position = Position::updateOrCreate([
                                    'name' => $value,
                                ]);
                                $position->save();
                            }
                            $dataArray['position_id'] = $position->id;

                            break;
                        default:
                            $dataArray[$key] = $value;
                            break;
                    }
                }

                $user = Employe::updateOrCreate($dataArray);
                $saved = $user->save();
                if (!$saved) {
                    $log = date('Y-m-d H:i:s') . ' Not saved - ' . print_r([$dataArray], true);
                    file_put_contents('/resources/files/log.txt', $log . PHP_EOL, FILE_APPEND);
                }
            }
        }
    }

}
