<?php

namespace Modules\Platform\MenuManager\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Modules\Platform\Core\Repositories\PlatformRepository;
use Modules\Platform\MenuManager\Helper\MenuHelper;
use Spatie\Menu\Laravel\Facades\Menu;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\View as SpatieView;

/**
 * Menu Repo
 *
 * Class MenuRepository
 * @package Modules\Platform\MenuManager\Repositories
 */
class MenuRepository extends PlatformRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return \Modules\Platform\MenuManager\Entities\Menu::class;
    }

    /**
     * Render Main menu
     *
     * @return static
     */
    public function renderMainMenu()
    {
        if (\Cache::has(MenuHelper::MAIN_MENU_CACHE_KEY)) {
            $mainMenuEloquent = \Cache::get(MenuHelper::MAIN_MENU_CACHE_KEY);
        } else {
            $mainMenuEloquent = $this->getMainMenu(false);
            \Cache::put(MenuHelper::MAIN_MENU_CACHE_KEY, $mainMenuEloquent, Carbon::now()->addDay(1));
        }

        $mainMenu = Menu::new();
        $mainMenu->addClass('list');
        $mainMenu->setActiveFromUrl(\Request::path());

        // Main Navigation

        $navigationTrans = 'core::core.menu.main_navigation';
        if (Lang::has('bap_menu.home')) {
            $navigationTrans = 'bap_menu.main_navigation';
        }

        $mainMenu->add(Html::raw(Lang::get($navigationTrans))->addParentClass('header'));

        foreach ($mainMenuEloquent as $menuElement) {
            if ($menuElement->parent_id == null) {
                if($menuElement->permission == '' || \Auth::user()->hasPermissionTo($menuElement->permission)) {
                    $this->renderMenuElement($mainMenu, $menuElement);
                }
            }
        }

        return $mainMenu;
    }

    /**
     * Get Main Menu form Database
     *
     * @param bool $all - show all menu elements including hidden
     * @return mixed
     */
    public function getMainMenu($all = true)
    {
        $result = $this->model->with('children')->orderBy('order_by', 'asc')
            ->where([
                'section' => MenuHelper::MAIN_MENU,
            ]);

        if (!$all) {
            $result->where([
                'visibility' => true
            ]);
        }




        return $result->get();
    }

    /**
     * Recursive menu render
     * @param $mainMenu
     * @param $menuElement
     */
    private function renderMenuElement($mainMenu, $menuElement)
    {
        $langPrefix = 'core::core.menu.';

        if (Lang::has('bap_menu.home')) {
            $langPrefix = 'bap_menu.';
        }

        if ($menuElement->children->count() > 0) {
            $submenu = Menu::new();
            $submenu->addClass('ml-menu');

            foreach ($menuElement->children as $element) {
                if($element->visibility > 0 ) {
                    $this->renderMenuElement($submenu, $element);
                }
            }


            if ($menuElement->visibility > 0) {
                $mainMenu->submenu(
                    SpatieView::create('core::menu-element', [
                        'cssClass' => 'menu-toggle',
                        'icon' => $menuElement->icon,
                        'name' => $menuElement->dont_translate == true ? $menuElement->label : Lang::get($langPrefix . $menuElement->label),
                        'url' => 'javascript:void(0);'
                    ]),
                    $submenu
                );
            }

        } else {
            if ($menuElement->permission != '') {
                $mainMenu->addIf(\Auth::user()->hasPermissionTo($menuElement->permission), SpatieView::create('core::menu-element', [
                    'icon' => $menuElement->icon,
                    'name' => $menuElement->dont_translate == true ? $menuElement->label : Lang::get($langPrefix . $menuElement->label),
                    'url' => $menuElement->url
                ]));
            } else {
                if ($menuElement->visibility > 0) {
                    $mainMenu->add(SpatieView::create('core::menu-element', [
                        'icon' => $menuElement->icon,
                        'name' => $menuElement->dont_translate == true ? $menuElement->label : Lang::get($langPrefix . $menuElement->label),
                        'url' => $menuElement->url
                    ]));
                }
            }
        }
    }
}
