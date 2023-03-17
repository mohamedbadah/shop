<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Filter implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $forbidden;
    protected $value;
    public function __construct($forbidden)
    {
        $this->forbidden=$forbidden;
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
        // if(strtolower($value)==$this->forbidden){
        //     return false;
        // }
        // return false;
        // return !(strtolower($value)==$this->forbidden);
        return !(in_array( strtolower($value),$this->forbidden));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "the name is forbidden!";
        // dd($this->forbidden[0]);
    }
}
