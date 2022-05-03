<?php

namespace Easy\MultiAuth\Service;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class Register
{
    /**
     * @var Validator
     */
    private Validator $validator;

    /**
     * @param Validator $validator
     */
    public function __construct(
        Validator $validator
    ) {
        $this->validator = $validator;
    }

    /**
     * @param array $requestArray
     * @param string $guard
     * @return mixed
     * @throws ValidationException
     */
    public function createUser(array $requestArray, string $guard = 'web'): mixed
    {
        $modelClass = $this->getModel($guard);
        $model = new $modelClass();
        return $this->save($model, $requestArray);
    }

    /**
     * @param int $id
     * @param array $requestArray
     * @param string $guard
     * @return mixed
     * @throws ValidationException
     */
    public function updateUser(int $id, array $requestArray, string $guard = 'web'): mixed
    {
        $model = $this->getUser($id, $guard);
        return $this->save($model, $requestArray, $id);
    }

    public function getUser(int $id, string $guard = 'web')
    {
        $modelClass = $this->getModel($guard);
        return $modelClass::findOrFail($id);
    }

    /**
     * @param $guard
     * @return mixed
     */
    private function getModel($guard): mixed
    {
        $auth = Config::get('auth');
        $provider = $auth['guards'][$guard]['provider'];
        return $auth['providers'][$provider]['model'];
    }

    /**
     * @param string $table
     * @param array $requestArray
     * @param int|null $id
     * @return array
     * @throws ValidationException
     */
    private function validateUser(string $table, array $requestArray, int $id = null): array
    {

        $errorBagName = $table . 'RegistrationError';

        $rules = [
            'active' => 'sometimes|required|bool',
            'name' => 'required|string|max:255',
        ];

        if ($id) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', Rule::unique($table, 'email')->ignore($id)];
            $rules['password'] = ['nullable', 'confirmed', Rules\Password::defaults()];
        } else {
            $rules['email'] = ['required', 'string', 'email', 'max:255', Rule::unique($table, 'email')];
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        return $this->validator::make($requestArray, $rules)->validateWithBag($errorBagName);
    }

    /**
     * @param mixed $model
     * @param array $requestArray
     * @param int|null $id
     * @return mixed
     * @throws ValidationException
     */
    private function save(mixed $model, array $requestArray, int $id = null): mixed
    {

        $table = $model->getTable();
        $validatedInputs = $this->validateUser($table, $requestArray, $id);
        if ($validatedInputs['password'] === '' || $validatedInputs['password'] === null){
            unset($validatedInputs['password']);
        } else {
            $validatedInputs['password'] =  Hash::make($validatedInputs['password']);
        }
        if (array_key_exists('active', $validatedInputs)){
            $validatedInputs['active'] = ($validatedInputs['active']) ? 1 : 0;
        }
        foreach ($validatedInputs as $key => $value) {
            $model->__set($key, $value);
        }
        $model->save();
        return $model;
    }
}
