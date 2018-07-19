<?php

namespace App\Traits;

use Illuminate\Foundation\Http\FormRequest;

trait TranslatedInput
{
    public function translatedInput($columns)
    {
    	if (!($this instanceof FormRequest)) {
    		throw new \Exception('This trait only accept FormRequest Instance');
    	}

		if (strpos($columns, '.') !== false) {
			$columns = explode('.', $columns);
		} elseif (!is_array($columns)) {
			$columns = [$columns];
		}

		$data   = array_intersect_key($this->input(), array_flip($columns));

		foreach ($data as $key => &$value) {
			$value = [$key => $value];
		}

		$result = [];

		foreach ($data as $column) {
			foreach (end($column) as $locale => $val) {
				$result[$locale][key($column)] = $val;
			}
		}

		return $result;
    }

}
