<?php

namespace App\Services\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class MediaPathGenerator implements PathGenerator
{
	public function getPath(Media $media): string
	{
		$parent_folder = str_replace(
			"App\\Models\\", 
			"", 
			$media->model_type
		);
		return "{$parent_folder}/model-{$media->model_id}_media-{$media->id}/";
	}

	public function getPathForConversions(Media $media): string
	{
		$parent_folder = str_replace(
			"App\\Models\\", 
			"", 
			$media->model_type
		);
		$nested_folder = "conversions";
		return "{$parent_folder}/model-{$media->model_id}_media-{$media->id}/{$nested_folder}/";
	}

	public function getPathForResponsiveImages(Media $media): string
	{
		$parent_folder = str_replace(
			"App\\Models\\", 
			"", 
			$media->model_type
		);
		$nested_folder = "responsive-images";
		return "{$parent_folder}/model-{$media->model_id}_media-{$media->id}/{$nested_folder}/";
	}
}