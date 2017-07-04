<?php

namespace Fg\Controller;

use Fg\Frame\Controller\Controller;
use Fg\Model\ItemModel;

/**
 * Class TreeController
 * @package Fg\Controller
 */
class TreeController extends Controller
{
    public $cats = [];
    public $items = [];

    /**
     * tree of goods
     *
     */
    public function tree()
    {
        $model = new ItemModel();
        $model->setTable('category');
        $model->setOrderBy(['name']);
        $this->cats = $model->getAll();
        $model->setTable('item');
        $this->items = $model->getAll();

        $body = '<h3 class="cat_string1">Catalog</h3><br><div class="col-lg-6 col-md-6 col-xs-12"><ul>';
        for ($i = 0; $i < count($this->cats); $i++) {
            if ($this->cats[$i]['parent_category_id'] == NULL) {
                $body .= "<li class='listnone'><span class='tree_root'>" . $this->cats[$i]['name'] . "</span><i class='tree_root_notice'>" . " (" . $this->cats[$i]['notice'] . ")</i>";
                $body .= $this->buildItem($this->cats[$i]['id']);
                $body .= $this->buildCat($this->cats[$i]['id']);
                $body .= "</li><h7>&nbsp;</h7>";
            }
        }
        $body .= "</ul></div>";

        $this->render($this->getViewFile(ROOTDIR . '/web/pages/tree.html.twig'), [], [], true, $body);
    }

    /**
     * build category branches in tree
     *
     * @param $id
     * @return string
     */
    public function buildCat($id)
    {
        $str = '<ul>';
        for ($z = 0; $z < count($this->cats); $z++) {
            if ($this->cats[$z]['parent_category_id'] == $id) {
                $str .= "<li class='listnone'><span class='glyphicon glyphicon-folder-open'>&nbsp;</span><span class='tree_branch'>" . $this->cats[$z]['name'] . "</span><i> (" . $this->cats[$z]['notice'] . ")</i>";
                $str .= $this->buildItem($this->cats[$z]['id']);
                $str .= $this->buildCat($this->cats[$z]['id']);
                $str .= "</li>";
            }
        }
        $str .= "</ul>";
        return $str;
    }

    /**
     * build items in tree
     *
     * @param $id
     * @return string
     */
    public function buildItem($id)
    {
        $str = '<ul>';
        for ($x = 0; $x < count($this->items); $x++) {
            if ($this->items[$x]['category_id'] == $id) {
                $str .= "<li class='listnone tree_item'><span id='star" . $this->items[$x]['id'] . "' class='glyphicon glyphicon-star-empty'></span>" .
                    "<a class='btn btn-primary btn-xs tree_link' 
                    val='" . $this->items[$x]['id'] . "'>" .
                    $this->items[$x]['name'] . "</a>";
                $str .= "</li>";
            }
        }
        $str .= "</ul>";

        return $str;
    }
}