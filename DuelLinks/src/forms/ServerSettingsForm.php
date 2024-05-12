<?php

declare(strict_types=1);

namespace wax_dev\DuelLinks\forms;

use Closure;
use wax_dev\DuelLinks\forms\elements\Image;

class ServerSettingsForm extends CustomForm{
	/** @var Image|null */
	private $image;

	/**
	 * @param string        $title
	 * @param               $elements
	 * @param Image|null    $image
	 * @param Closure      $onSubmit
	 * @param Closure|null $onClose
	 */
	public function __construct(string $title, $elements, ?Image $image, Closure $onSubmit, ?Closure $onClose = null){
		parent::__construct($title, $elements, $onSubmit, $onClose);
		$this->image = $image;
	}

	/**
	 * @return bool
	 */
	public function hasImage() : bool{
		return $this->image !== null;
	}

	/**
	 * @return array
	 */
	public function serializeFormData() : array{
		$data = parent::serializeFormData();
		if($this->hasImage()){
			$data["icon"] = $this->image;
		}
		return $data;
	}
}