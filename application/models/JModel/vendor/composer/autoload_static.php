<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2dfeb15d86e500a86a4393972ea64f82
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Model\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Model',
        ),
    );

    public static $classMap = array (
        'Model\\Callback' => __DIR__ . '/../..' . '/Model/Callback.php',
        'Model\\Core' => __DIR__ . '/../..' . '/Model/Core.php',
        'Model\\Table\\Advertisements' => __DIR__ . '/../..' . '/Model/Table/Advertisements.php',
        'Model\\Table\\AdvertisementsItems' => __DIR__ . '/../..' . '/Model/Table/AdvertisementsItems.php',
        'Model\\Table\\Categories' => __DIR__ . '/../..' . '/Model/Table/Categories.php',
        'Model\\Table\\Customers' => __DIR__ . '/../..' . '/Model/Table/Customers.php',
        'Model\\Table\\DictionaryMembers' => __DIR__ . '/../..' . '/Model/Table/DictionaryMembers.php',
        'Model\\Table\\Eloquent\\Categories' => __DIR__ . '/../..' . '/Model/Table/Eloquent/Categories.php',
        'Model\\Table\\Eloquent\\Customer' => __DIR__ . '/../..' . '/Model/Table/Eloquent/Customer.php',
        'Model\\Table\\Eloquent\\Items' => __DIR__ . '/../..' . '/Model/Table/Eloquent/Items.php',
        'Model\\Table\\Eloquent\\Order' => __DIR__ . '/../..' . '/Model/Table/Eloquent/Order.php',
        'Model\\Table\\Eloquent\\OrderDetail' => __DIR__ . '/../..' . '/Model/Table/Eloquent/OrderDetail.php',
        'Model\\Table\\Eloquent\\Product' => __DIR__ . '/../..' . '/Model/Table/Eloquent/Product.php',
        'Model\\Table\\Eloquent\\Profiles' => __DIR__ . '/../..' . '/Model/Table/Eloquent/Profiles.php',
        'Model\\Table\\Eloquent\\Roles' => __DIR__ . '/../..' . '/Model/Table/Eloquent/Roles.php',
        'Model\\Table\\Eloquent\\Users' => __DIR__ . '/../..' . '/Model/Table/Eloquent/Users.php',
        'Model\\Table\\Items' => __DIR__ . '/../..' . '/Model/Table/Items.php',
        'Model\\Table\\Karyawans' => __DIR__ . '/../..' . '/Model/Table/Karyawans.php',
        'Model\\Table\\NotificationState' => __DIR__ . '/../..' . '/Model/Table/NotificationState.php',
        'Model\\Table\\OrderDetails' => __DIR__ . '/../..' . '/Model/Table/OrderDetails.php',
        'Model\\Table\\OrderKaryawans' => __DIR__ . '/../..' . '/Model/Table/OrderKaryawans.php',
        'Model\\Table\\Orders' => __DIR__ . '/../..' . '/Model/Table/Orders.php',
        'Model\\Table\\Products' => __DIR__ . '/../..' . '/Model/Table/Products.php',
        'Model\\Table\\ProductsHistories' => __DIR__ . '/../..' . '/Model/Table/ProductsHistories.php',
        'Model\\Table\\ProductsPrices' => __DIR__ . '/../..' . '/Model/Table/ProductsPrices.php',
        'Model\\Table\\ProductsRelations' => __DIR__ . '/../..' . '/Model/Table/ProductsRelations.php',
        'Model\\Table\\Profiles' => __DIR__ . '/../..' . '/Model/Table/Profiles.php',
        'Model\\Table\\Requesters' => __DIR__ . '/../..' . '/Model/Table/Requesters.php',
        'Model\\Table\\Roles' => __DIR__ . '/../..' . '/Model/Table/Roles.php',
        'Model\\Table\\Suppliers' => __DIR__ . '/../..' . '/Model/Table/Suppliers.php',
        'Model\\Table\\Support' => __DIR__ . '/../..' . '/Model/Table/Support.php',
        'Model\\Table\\UnitSatuans' => __DIR__ . '/../..' . '/Model/Table/UnitSatuans.php',
        'Model\\Table\\Users' => __DIR__ . '/../..' . '/Model/Table/Users.php',
        'Model\\Table\\VGraphMemberService' => __DIR__ . '/../..' . '/Model/Table/VGraphMemberService.php',
        'Model\\Table\\VGraphMemberTransact' => __DIR__ . '/../..' . '/Model/Table/VGraphMemberTransact.php',
        'Model\\Table\\VGraphNonMemberService' => __DIR__ . '/../..' . '/Model/Table/VGraphNonMemberService.php',
        'Model\\Table\\VGraphProdukSold' => __DIR__ . '/../..' . '/Model/Table/VGraphProdukSold.php',
        'Model\\Table\\VGudangOrderDetails' => __DIR__ . '/../..' . '/Model/Table/VGudangOrderDetails.php',
        'Model\\Table\\VNotificationState' => __DIR__ . '/../..' . '/Model/Table/VNotificationState.php',
        'Model\\Table\\VOrderDetail' => __DIR__ . '/../..' . '/Model/Table/VOrderDetail.php',
        'Model\\Table\\VProductAll' => __DIR__ . '/../..' . '/Model/Table/VProductAll.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2dfeb15d86e500a86a4393972ea64f82::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2dfeb15d86e500a86a4393972ea64f82::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2dfeb15d86e500a86a4393972ea64f82::$classMap;

        }, null, ClassLoader::class);
    }
}