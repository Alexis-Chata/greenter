<?php

namespace App\Rules;

use App\Models\Company;
use Illuminate\Contracts\Validation\Rule;

class UniqueCompanyRule implements Rule
{
    public $company_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($company_id = null)
    {
        $this->company_id = $company_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $company = Company::where('ruc', $value)
            ->where('user_id', auth()->id())
            ->when($this->company_id, function($query, $company_id){
                $query->where('id', '!=', $company_id);
            })
            ->first();

            if ($company) {
                return false;
            }
            return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ya existe una empresa con este RUC';
    }

}
