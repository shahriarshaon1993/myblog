<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Get all categories from database
     *
     * @return void
     */
    public function getAllCategories()
    {
        return Category::orderBy('id', 'desc')->get();
    }

    /**
     * Add category in database
     *
     * @param  mixed $request
     * @return void
     */
    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'iconImage' => 'required'
        ]);

        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage' => $request->iconImage
        ]);
    }

    /**
     * Category icon image upload logic
     *
     * @param  mixed $request
     * @return void
     */
    public function uploadCategoryFile(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:png,jpg,jpeg'
        ]);

        $picName = time().'.'. $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    /**
     * Delete category image file from directory
     *
     * @param  mixed $request
     * @return void
     */
    public function deleteCategoryImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName);
        return 'done';
    }

    /**
     * Delete File From Server
     *
     * @param  mixed $fileName
     * @return void
     */
    public function deleteFileFromServer($fileName)
    {
        $filePath = public_path().'/uploads/'.$fileName;
        if(file_exists($filePath)) {
            @unlink($filePath);
        }
    }
}