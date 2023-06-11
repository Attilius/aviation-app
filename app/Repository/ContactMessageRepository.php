<?php

namespace App\Repository;

use App\Contracts\ContactMessageRepositoryInterface;
use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ContactMessageRepository implements ContactMessageRepositoryInterface
{

    public function findAll(): Collection
    {
        return ContactMessage::all();
    }

    public function findById($id): Model
    {
        return ContactMessage::where('id', $id)->get();
    }

    public function store(array $data): Model
    {
        Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string']
        ])->validate();

        return ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message']
        ]);
    }

    public function update(array $data = []): void
    {
        ContactMessage::where('id', $data['id'])->update([
            'is_had_answer' => true
        ]);
    }

    public function destroy($id, string $email): void
    {
        // TODO: Implement destroy() method.
    }
}
