<?php

/*Consultas BD*/

    //Puede utilizar el tablemétodo proporcionado por la DBfachada para iniciar una consulta. El tablemétodo devuelve una instancia fluida del generador de consultas para la tabla dada, lo que le permite encadenar más restricciones a la consulta y luego recuperar los resultados de la consulta usando el getmétodo
    
        use Illuminate\Support\Facades\DB;

        $empleados = DB::table('iprodha.empleados')->get();

    //El 'get' método devuelve una Illuminate\Support\Collection instancia que contiene los resultados de la consulta donde cada resultado es una instancia del stdClassobjeto PHP. 
    //Puede acceder al valor de cada columna accediendo a la columna como una propiedad del objeto
    
        foreach ($empleados as $empleado) {
            echo $empleado->nombre;
        }

    //First Recupera la primera fila
        $empleado = DB::table('empleados')->where('nombre', 'John')->first();

    //Value Recupera una columna  (verificar.. devuelve un solo valor.. la primer fila de la consulta)
        $email = DB::table('empleados')->where('nombre', 'John')->value('email');

    //Find Recupera una Fila por el 'id' (definido dentro del modelo)
        $empleado = DB::table('empleados')->find(3);

    //Pluck Recupera todos los valores de una sola columna 
        $nombres = DB::table('empleados')->pluck('nombre');
    
        foreach ($nombres as $nombre) {
            echo $nombre;
        }

    //Modificacion al metodo Pluck.. Puede especificar la columna que la colección resultante debe usar como sus claves proporcionando un segundo argumento para el pluckmétodo:
    
        $empleados = DB::table('empleados')->pluck('nombre', 'id_emple');

        foreach ($empleados as $id_emple => $nombre) {
            echo $nombre;
        }

    //Si necesita trabajar con miles de registros de bases de datos, considere usar el chunkmétodo proporcionado por la DBfachada. Este método recupera una pequeña parte de los resultados a la vez y alimenta cada parte en un cierre para su procesamiento. Por ejemplo, recuperemos toda la userstabla en fragmentos de 100 registros a la vez
        use Illuminate\Support\Facades\DB;
    
        DB::table('empleados')->orderBy('id')->chunk(100, function ($users) {
            foreach ($users as $user) {
                //
            }
        });

    //count, max, min, avgy sum
        $users = DB::table('empleados')->count();
    
        $precio = DB::table('orders')->max('precio');

    //Por supuesto, puede combinar estos métodos con otras cláusulas para ajustar cómo se calcula su valor agregado:

        $precio = DB::table('orders')->where('finalizados', 1)->avg('precio');

    //En lugar de usar el countmétodo para determinar si existe algún registro que coincida con las restricciones de su consulta, puede usar los métodos existsy :doesntExist

        if (DB::table('orders')->where('finalized', 1)->exists()) {
            // ...
        }
        
        if (DB::table('orders')->where('finalized', 1)->doesntExist()) {
            // ...
        }



    //Es posible que no siempre desee seleccionar todas las columnas de una tabla de base de datos. Usando el selectmétodo, puede especificar una cláusula de "selección" personalizada para la consulta
 
        $users = DB::table('users')
                    ->select('nombre', 'email as user_email')
                    ->get();

    //El distinctmétodo le permite forzar la consulta para que devuelva resultados distintos

        $users = DB::table('users')->distinct()->get();

    //Si ya tiene una instancia del generador de consultas y desea agregar una columna a su cláusula de selección existente, puede usar el addSelectmétodo

        $query = DB::table('users')->select('nombre');
    
        $users = $query->addSelect('email')->get();

    //Para realizar una "unión interna" básica, puede usar el joinmétodo en una instancia del generador de consultas. El primer argumento que se pasa al joinmétodo es el nombre de la tabla a la que debe unirse, mientras que los argumentos restantes especifican las restricciones de columna para la unión.

        $users = DB::table('users')
                ->join('contactos', 'users.id', '=', 'contactos.user_id')
                ->join('ordenes', 'users.id', '=', 'ordenes.user_id')
                ->select('users.*', 'contactos.phone', 'ordenes.precio')
                ->get();

        $users = DB::table('users')
                ->leftJoin('posteos', 'users.id', '=', 'posteos.user_id')
                ->get();
    
        $users = DB::table('users')
                ->rightJoin('posteos', 'users.id', '=', 'posteos.user_id')
                ->get();

    //Puede utilizar el crossJoinmétodo para realizar una "unión cruzada". Las uniones cruzadas generan un producto cartesiano entre la primera tabla y la tabla unida
    
        $sizes = DB::table('sizes')
                ->crossJoin('colors')
                ->get();


    //Cláusulas de unión avanzadas
    //También puede especificar cláusulas de combinación más avanzadas. Para comenzar, pase un cierre como segundo argumento del joinmétodo.
        DB::table('users')
            ->join('contacts', function ($join) {
                $join->on('users.id', '=', 'contacts.user_id')->orOn(/* ... */);
            })
            ->get();
    
    //Si desea utilizar una cláusula "dónde" en sus uniones, puede utilizar los métodos wherey proporcionados por la instancia. En lugar de comparar dos columnas, estos métodos compararán la columna con un valor
        DB::table('users')
            ->join('contacts', function ($join) {
                $join->on('users.id', '=', 'contacts.user_id')
                    ->where('contacts.user_id', '>', 5);
            })
            ->get();

    //Where Clausulas
        $users = DB::table('users')
                    ->where('votes', '=', 100)
                    ->where('age', '>', 35)
                    ->get();

    //Como se mencionó anteriormente, puede usar cualquier operador que sea compatible con su sistema de base de datos:
        $users = DB::table('users')
                        ->where('votes', '>=', 100)
                        ->get();
        
        $users = DB::table('users')
                        ->where('votes', '<>', 100)
                        ->get();
        
        $users = DB::table('users')
                        ->where('name', 'like', 'T%')
                        ->get();

    //También puede pasar una serie de condiciones a la wherefunción.

        $users = DB::table('users')->where([
            ['status', '=', '1'],
            ['subscribed', '<>', '1'],
        ])->get();

    //Al encadenar llamadas al where método del generador de consultas, las cláusulas "where" se unirán mediante el andoperador. Sin embargo, puede usar el orWheremétodo para unir una cláusula a la consulta usando el oroperador. El orWheremétodo acepta los mismos argumentos que el where método
        
        $users = DB::table('users')
                    ->where('votes', '>', 100)
                    ->orWhere('name', 'John')
                    ->get();

        //Si necesita agrupar una condición "o" entre paréntesis, puede pasar un cierre como primer argumento del orWheremétodo
            $users = DB::table('users')
                        ->where('votes', '>', 100)
                        ->orWhere(function($query) {
                            $query->where('name', 'Abigail')
                                ->where('votes', '>', 50);
                        })
                        ->get();

        //El ejemplo anterior producirá el siguiente SQL
        
            select * from users where votes > 100 or (name = 'Abigail' and votes > 50)
    
    //Los métodos whereNoty orWhereNotse pueden usar para negar un grupo determinado de restricciones de consulta. Por ejemplo, la siguiente consulta excluye productos que están en liquidación o que tienen un precio inferior a diez

        $products = DB::table('products')
                ->whereNot(function ($query) {
                    $query->where('clearance', true)
                          ->orWhere('price', '<', 10);
                })
                ->get();
    
    //El whereBetweenmétodo verifica que el valor de una columna esté entre dos valores
        $users = DB::table('users')
                ->whereBetween('votes', [1, 100])
                ->get();
    //El whereNotBetweenmétodo verifica que el valor de una columna se encuentra fuera de dos valores
        $users = DB::table('users')
                ->whereNotBetween('votes', [1, 100])
                ->get();
    //El whereInmétodo verifica que el valor de una columna dada esté contenido dentro de la matriz dada
        $users = DB::table('users')
                        ->whereIn('id', [1, 2, 3])
                        ->get();
    //El whereNotInmétodo verifica que el valor de la columna dada no esté contenido en la matriz dada
        $users = DB::table('users')
                        ->whereNotIn('id', [1, 2, 3])
                        ->get();
    //El whereNullmétodo verifica que el valor de la columna dada es NULL
        $users = DB::table('users')
                    ->whereNull('updated_at')
                    ->get();







/*MODELO*/





    protected $table = 'empleados';         //Nombre de la tabla
    protected $primaryKey = 'id';           //Nombre del id de la tabla
    public $incrementing = false;           //'False' Autogestion del id
    protected $keyType = 'string';          //Tipo de dato del id
    public $timestamps = false;             //'True' Agrega valores de manera automatica a las columnas crated_at updated_at del modelo

    //Claves Primarias Compuestas no Tienen Compatibilidad con Eloquent

    const CREATED_AT = 'creation_date';     //Personalizar el nombre de las columnas de timestamps
    const UPDATED_AT = 'updated_date';

    protected $connection = 'sqlite';       //El tipo de conexion a utilizar

    protected $attributes = [               //Si Queremos darle valores por defecto a nuestro modelo
        'tiene_Categoria' => false,         //si no posee velor en ese atributo
        'nombre_categoria'=> 'sin nombre'
    ];



    /*Consultas Modelo*/

    //Se puede pensar en cada modelo de Eloquent como un poderoso generador de consultas que le permite consultar con fluidez la tabla de la base de datos asociada con el modelo.

    use App\Models\Empleado;
    
    Empleado::all()     //El 'all' método del modelo Eloquent recuperará todos los registros de la tabla de la base de datos asociada al modelo











    