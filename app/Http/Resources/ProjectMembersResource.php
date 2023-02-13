<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectMembersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'user' => [
                'id' => $this->collection,
                // 'full_name' => $this->members->full_name,
                // 'firstname' => $this->members->firstname,
                // 'lastname' => $this->members->lastname,
                // 'mail_notification' => $this->members->mail_notification,
            ],
            'roles' => [
                // 'role_id' => $this->members->member_roles->roles
            ],
        ];
    }
}
