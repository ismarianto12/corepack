<?php

// create by ismarianto

namespace Ismarianto\Ismarianto\App\Lib;

use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Illuminate\Support\Facades\Auth;
use Modules\Ismarianto\Models\Tmmodul;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ModulApp
{

    public $level;
    public $route;

    public static function menu_app($level)
    {
        $query = \DB::table('tmmodul')->select(
            'id',
            'id_parent',
            'nama_menu',
            'icon',
            'link',
            'aktif',
            'urutan',
            'position',
            'level',
            'users_id',
            'created_at',
            'updated_at'
        );
        if (Tmparamtertr::session('rote') == 'admin') {
            $qrdata =  $query->get();
        } else {
            $qrdata =  $query->where(\DB::Raw("CHARINDEX('" . $level . "', [level])"), '>', 0)->get();
        }
        $menu = array('items' => array(), 'parents' => array());
        foreach ($qrdata as $menus) {
            $menu['items'][$menus->id] = $menus;
            $menu['position'][$menus->position] = $menus->position;
            $menu['parents'][$menus->id_parent][] = $menus->id;
        }
        if ($menu) {
            $result = self::buitlmenu(0, $menu);
            return $result;
        } else {
            return FALSE;
        }
    }

    public static function buitlmenu($parent, $menu)
    {
        $html = "";
        if (isset($menu['parents'][$parent])) {
            if ($parent == '0') {
                $html .= "<li><a href='" . Url('/dashboard') . "' id='navbar'><span> Home</span><br /></li>";
            } else {
                $html .= '<ul class="dropdown-menu">';
            }
            foreach ($menu['parents'][$parent] as $itemId) {

                $pasurl = isset($menu['items'][$itemId]->link) ? $menu['items'][$itemId]->link : '/';

                $icon = ($menu['items'][$itemId]->icon) ? '<i class="' . $menu['items'][$itemId]->icon . '"></i>' : '<i class="fa fa-list"></i>';

                if (!isset($menu['parents'][$itemId])) {
                    $pasurl = isset($menu['items'][$itemId]->link) ? str_replace('.index', '/', $menu['items'][$itemId]->link) : '/';

                    if ($menu['items'][$itemId]->id_parent == 0) :
                        $html .= "<li><a class='nav-link' href='" . Url($pasurl) . "'>" . $icon . "<span>" . $menu['items'][$itemId]->nama_menu . "</span></a></li>";
                    else :
                        $html .= "<li><a class='nav-link' href='" . Url($pasurl) . "'>" . $menu['items'][$itemId]->nama_menu . "</a></li>";
                    endif;
                }
                if (isset($menu['parents'][$itemId])) {

                    $html .= "<li class='dropdown'><a class='nav-link has-dropdown' href='" . strtolower($menu['items'][$itemId]->link) . "' data-toggle='dropdown'>" . $icon . "<span>" . $menu['items'][$itemId]->nama_menu . "</span></a>";

                    $html .= self::buitlmenu($itemId, $menu);
                    $html .= "</li>";
                }
            }
            $html .= "</ul>";
        }
        return $html;
    }


    // public function replace()
    // {
    // }
}
