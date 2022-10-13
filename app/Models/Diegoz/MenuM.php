<?php

namespace App\Models\Diegoz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuM extends Model
{
    
    protected $table = 'diegoz.grant_menu';
    public $timestamps = true;

    
    protected $fillable = [ 
        'idmenu',    'nommenu', 
        'tipo','idmenupadre',
        'orden','visible', 
        'CREATED_AT','updated_at'
    ];
    
    protected $primaryKey = 'idmenu';
    public $incrementing = false;
    
    public function getChildren($data, $line)
    {
        $children = [];
        $bandera=0;
        foreach ($data as $line1) {
            if ($bandera!=0) {
                if ($line->idmenu == $line1->idmenupadre) {
                    $children = array_merge($children, [ array_merge(get_object_vars($line1), ['submenu' => $this->getChildren($data, $line1) ]) ]);
                }
            } else {
                $bandera=1;
            }   
        }
        return $children;
    }
    public function optionsMenu()
    {
        return DB::table('diegoz.grant_menu')
            ->leftJoin('diegoz.grant_vista', 'diegoz.grant_menu.idvista', '=', 'diegoz.grant_vista.idvista')
            ->leftJoin('diegoz.grant_menuxpermisos','diegoz.grant_menuxpermisos.idmenu','=','diegoz.grant_menu.idmenu')
            ->leftJoin('diegoz.permissions', 'diegoz.grant_menuxpermisos.idpermiso', '=', 'diegoz.permissions.id')
            //->selectRaw('diegoz.grant_menu.idmenu,diegoz.grant_menu.nommenu,diegoz.grant_menu.idmenupadre,diegoz.grant_menu.orden,diegoz.grant_menu.visible,(case when diegoz.grant_vista.idvista is NULL then 1 else 0 end) AS tipo')
            ->select('diegoz.grant_menu.*','diegoz.permissions.*','diegoz.grant_vista.nomvista','diegoz.grant_vista.rol')//DB::raw('(case when diegoz.grant_vista.idvista is NULL then 1 else 0 end) AS tipo')
            ->where('diegoz.grant_menu.visible', 1)
            //->orderby('diegoz.grant_menu.idmenu')
            ->orderby('diegoz.grant_menu.idmenupadre')
            ->orderby('diegoz.grant_menu.orden')
            //->orderby('diegoz.grant_menu.nommenu')
            //->orderby('diegoz.grant_menu.idmenu')
            ->get()
            ->toArray();
    }
    public function optionsMenuGrupo()
    {
        return DB::table('diegoz.grant_menu')
            ->leftJoin('diegoz.grant_vista', 'diegoz.grant_menu.idvista', '=', 'diegoz.grant_vista.idvista')
            ->leftJoin('diegoz.grant_menuxpermisos','diegoz.grant_menuxpermisos.idmenu','=','diegoz.grant_menu.idmenu')
            ->leftJoin('diegoz.permissions', 'diegoz.grant_menuxpermisos.idpermiso', '=', 'diegoz.permissions.id')
            ->select('diegoz.grant_menu.*','diegoz.permissions.*','diegoz.grant_vista.nomvista','diegoz.grant_vista.rol')
            ->orderby('diegoz.grant_menu.idmenupadre')
            ->orderby('diegoz.grant_menu.orden')
            ->get()
            ->toArray();
    }
    public function optionsMenuUnaVista($name)
    {
        return DB::table('diegoz.grant_menu')
            ->leftJoin('diegoz.grant_vista', 'diegoz.grant_menu.idvista', '=', 'diegoz.grant_vista.idvista')
            ->leftJoin('diegoz.grant_menuxpermisos','diegoz.grant_menuxpermisos.idmenu','=','diegoz.grant_menu.idmenu')
            ->leftJoin('diegoz.permissions', 'diegoz.grant_menuxpermisos.idpermiso', '=', 'diegoz.permissions.id')
            ->select('diegoz.grant_menu.*','diegoz.permissions.*','diegoz.grant_vista.nomvista')//DB::raw('(case when diegoz.grant_vista.idvista is NULL then 1 else 0 end) AS tipo')
            ->where('diegoz.grant_vista.nomvista', '=', $name)->orWhereNull('diegoz.grant_vista.nomvista')
            ->orderby('diegoz.grant_menu.idmenupadre')
            ->orderby('diegoz.grant_menu.orden')

            ->get()
            ->toArray();
    }
    public function menus($id)
    {
        $menus = new MenuM();
        if ($id==1) {
            //menu sidebar de la App
            $data = $menus->optionsMenu();
        }else {
            //menu arbol de la vista para crear grupos
            //menu arbol para vista.index
            $data = $menus->optionsMenuGrupo();
        }
        $menuAll = [];
        
        foreach ($data as $line) {
            $item = [ array_merge( get_object_vars($line), ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        
        return $menus->menuAll = $menuAll;
        
    }

    public function menusUnaVista($name)
    {
        $menus = new MenuM();
       
        $data = $menus->optionsMenuUnaVista($name);
        
        $menuAll = [];
        
        foreach ($data as $line) {
            $item = [ array_merge( get_object_vars($line), ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        
        return $menus->menuAll = $menuAll;
        
    }
}
