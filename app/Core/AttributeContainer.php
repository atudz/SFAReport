<?php

namespace App\Core;

use Symfony\Component\HttpKernel\DataCollector\Util\ValueExporter;
use RuntimeException;

/**
 * This class defines an abstract support for custom attributes
 * 
 * @author abner
 *
 */
class AttributeContainer
{
	/**
	 * The attributes for the class;
	 * 
	 * @var $attribute
	 */
	protected $attributes = [];
	
	/**
	 * The attribute values for the class;
	 *
	 * @var $attributeData
	 */
	protected $attributeData = [];
	
	
	
	/**
	 * Magic get method used for getting class's attribute values
	 * @param $attribute The attribute name
	 * @return Returns the attribute Value
	 */
	public function __get($attribute)
	{
		if(!isset($this->attributes[$attribute]))
		{
			// Throw an error
			throw new RuntimeException("The $attribute is not supported.");
		}
		
		// supports custom method accessor
		if(method_exists($this, $attribute))
		{
			$attribute = ucfirst($attribute);
			call_user_func([$this,$attribute]);
		}
		
		// return attibute value
		return $this->attributeData[$attribute];
	}
	
	
	/**
	 * Magic set method used for setting class's attribute values
	 * @param $attribute The attribute name
	 * @param $value The attribute value
	 */
	public function __set($attribute, $value)
	{
		if(!isset($this->attributes[$attribute]))
		{
			// Throw an error
			throw new RuntimeException("The $attribute is not supported.");
		}
		
		$this->validateAttributeValue($attribute, $value);
	
		// supports custom method accessor
		if(method_exists($this, $attribute))
		{
			$attribute = ucfirst($attribute);
			call_user_func([$this,$attribute], $value);
		}
	
		// set attribute value
		$this->attributeData[$attribute] = $value;
	}
	
	
	/**
	 * Magic isset method used for determining if attribute is set
	 * @param $attribute The attribute name
	 * @return bool True if is set, otherwise false
	 */
	public function __isset($attribute)
	{
		if(!isset($this->attributes[$attribute]))
		{
			// Throw an error
			throw new RuntimeException("The $attribute is not supported.");
		}
		
		return isset($this->attributes[$attribute]);
	}
	
	/**
	 * Magic unset method used for unsetting attribute
	 * @param $attribute The attribute name
	 * 
	 */
	public function __unset($attribute)
	{
		if(!isset($this->attributes[$attribute]))
		{
			// Throw an error
			throw new RuntimeException("The $attribute is not supported.");
		}
		
		unset($this->attributes[$attribute], $this->attributeData[$attribute]);
	}
	
	/**
	 * This method will validate an attribute value that does not have an overridden
	 * modifier method.
	 *
	 * @param $attributeName
	 * @param $attributeValue
	 * @return bool
	 * @throws RuntimeException
	 */
	protected function validateAttributeValue( $attributeName , $attributeValue )
	{
		if( $attributeValue === null )
		{
			// null is always an allowed value, as this resets the status of the attribute
			return true;
		}
	
		$exceptionMessage = '';
	
		switch( $this->attributes[$attributeName] )
		{
			case 'string':
					
				// scrub for an empty string
	
				if( ! is_string( $attributeValue ) )
				{
					$exceptionMessage = 'The requested property %s must be a string.';
				}
	
				break;
	
			case 'array':
	
				if( ! is_array( $attributeValue ) && $attributeValue !== null )
				{
					$exceptionMessage = 'The requested property %s must be an array.';
				}
	
				break;
	
			case 'int':
			case 'float':
	
				/**
					* we are going to scrub false values and default them to zero. it is annoying to
					* get exceptions when an empty string gets in this far.
					*/
	
				if( ! $attributeValue )
				{
					$attributeValue = 0;
				}
	
				if( ! is_numeric( $attributeValue ) )
				{
					$exceptionMessage = 'The requested property %s must be numeric.';
				}
	
				break;
	
			case 'boolean':
	
				break;
	
			default:
	
				if( ! $attributeValue instanceof $this->attributes[$attributeName] && $attributeValue !== null )
				{
					$exceptionMessage = 'The requested property %s must be an object of '
							. $this->attributes[$attributeName];
				}
	
				break;
		}
		
		// check to see if the exception message was set
		
		if( $exceptionMessage )
		{
			$finalMessage = sprintf( $exceptionMessage , $attributeName );
			throw new RuntimeException($finalMessage);
		}
		
		return true;
		
	}
}