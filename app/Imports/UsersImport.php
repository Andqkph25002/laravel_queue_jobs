<?php

namespace App\Imports;

use App\Jobs\CreateUserKeycloakJob;
use App\Jobs\SendEmailJob;
use App\Models\User;
use App\Traits\KeyCloak;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    use KeyCloak;
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        $token = $this->getTokenKeycloak();
        foreach ($collection as $row) {

            User::create([
                'username' => $row[0],
                'email' => $row[1],
                'password' => $row[2],
            ]);


            //Đồng bộ user trên Keycloak
            CreateUserKeycloakJob::dispatch($token , $row[0] , $row[1]);

            //Gửi gmail
            $subject = 'Email từ Khánh An';
            $message = 'Bạn đã đăng ký thành công !';
            SendEmailJob::dispatch($row[1], $subject, $message);
        }
    }
}
