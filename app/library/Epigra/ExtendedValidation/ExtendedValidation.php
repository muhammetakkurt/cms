<?php namespace Epigra\ExtendedValidation;
	
	use Illuminate\Validation;

	/**
	*	Extended validation class
	*	@name Extended Validation
	*	@package Epigra\ExtendedValidation
	*	@author Hilmi Erdem KEREN
	*	@version 1.5
	*	@uses Illuminate\Validation
	*	@superpress: Validator
	*/
	class ExtendedValidator extends \Illuminate\Validation\Validator {
		
		// Alpha
		// tr{[a-z]}
	    public function validateAlphaGlobal($attribute, $value, $parameters)
	    {
	    	// \p[L]: (L known as Letter, Any kind of letter from any language)
	    	// \p[Mn]: (Mn known as combined letters like umlauts or accents)
	        return preg_match('/^[\\p{L}\\p{Mn}]+$/u', $value);
	    }

	    // Alpha Space
	    // tr{[a-z]} + \s
	    public function validateAlphaSpaceGlobal($attribute, $value, $parameters)
	    {
	    	return preg_match('/^[\\p{L}\\p{Mn}\s]+$/u', $value);
	    }

	    // Alpha Numeric
	    // tr{[a-z]} + [0-9]
	    public function validateAlphaNumGlobal($attribute, $value, $paramters)
	    {
	        return preg_match('/^[\\p{L}\\p{Mn}0-9]+$/u', $value);
	    }

	    // Alpha Numeric with Dashes
	    // tr{[a-z]} + [0-9] + [-_]
	    public function validateAlphaDashGlobal($attribute, $value, $parameters)
	    {
	        return preg_match('/^[\\p{L}\\p{Mn}0-9_-]+$/u', $value);
	    }

	    // Alpha Numeric with Space
	    // tr{[a-z]} + [0-9] + \s
	    public function validateAlphaNumSpaceGlobal($attribute, $value, $parameters)
	   	{
	   		return preg_match('/^[\\p{L}\\p{Mn}0-9\s]+$/u', $value);
	   	}

	   	// Alpha Numeric Space with Dashes
	    // tr{[a-z]} + [0-9] + [-_] + \s
	    public function validateAlphaDashSpaceGlobal($attribute, $value, $parameters)
	   	{
	   		// \s: (Space Bar)
	   		return preg_match('/^[\\p{L}\\p{Mn}0-9_-\s]+$/u', $value);
	   	} 

		 protected function validateAfterField($attribute, $value, $parameters)
		{
			$other = $parameters[0];
			return (isset($this->data[$other]) and (strtotime($value) > strtotime($this->data[$other])));
		}

		protected function validateBeforeField($attribute, $value, $parameters)
		{
			$other = $parameters[0];
			return (isset($this->data[$other]) and (strtotime($value) < strtotime($this->data[$other])));
		}

	}
/* End of extendedValidation.php */