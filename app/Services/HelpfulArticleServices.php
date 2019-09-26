<?php
/**

Helpful Article services class to hold the related action logics

*/

namespace App\Services;

use App\HelpfulArticle;
use Yajra\Datatables\Datatables;

class HelpfulArticleServices{

	public function listArticles(){

		$articles = HelpfulArticle::select(['id','title','description','is_active',
												'ordering'])->orderBy('ordering', 'ASC');

		return Datatables::of($articles)
        			->addColumn('status_text',function($articles){
                		return $articles->getDescriptionText($articles->is_active);
        			})
                	->addColumn('action', function ($articles) {
	                    $buttons = ' <button ng-click="editArticle(' . $articles->id . ')" '
	                            . 'title="Edit" alt="Edit" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-blue pr-0">'
	                            . '<ion-icon name="create"></ion-icon></button>';

	                    $buttons .= ' <button ng-click="deleteArticle(' . $articles->id . ')" '
	                            . 'title="Delete" alt="Delete" '
	                            . 'class="btn btn-circle btn-mn bg-transparent fs-18 text-danger pr-0">'
	                            . '<ion-icon name="close"></ion-icon></button>';
                    return $buttons;
                })->make(true);

	}

	public function getInfo($id) {

        $article = HelpfulArticle::find($id);
        $rv = array("status" => "SUCCESS", "article" => $article);
        return response()->json($rv);
    }


    public function addOrUpdate($datas) {
        try {

            if (isset($datas->id)) {
                $article = HelpfulArticle::find($datas->id);
            } else {
                $article = new HelpfulArticle;
            }
            
            $article->title = $datas->title;
            $article->description = $datas->description;
            if(isset($datas->ordering)){
                $article->ordering = $datas->ordering;
            }

            if($datas->is_active == HelpfulArticle::FLAG_YES){
                $article->is_active = HelpfulArticle::FLAG_YES;
            }else{
                $article->is_active = HelpfulArticle::FLAG_NO;
            }

            $article->save();           
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false;
        }
    }

    public function delete($id){
        try{
        	HelpfulArticle::destroy($id); 
        	return true;        
        }catch(\Exception $e){
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return false; 
        }
    }

    public function getActiveArticles(){
        return HelpfulArticle::select('id','title','description')
                    ->where('is_active', HelpfulArticle::FLAG_YES)
                    ->orderBy('ordering', 'ASC')
			        ->get();
    }

}