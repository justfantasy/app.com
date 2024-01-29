<?php

use yii\db\Migration;

/**
 * Class m240129_131454_init
 */
class m240129_131454_init extends Migration
{
    public function up()
    {
        # 菜单表，表结构
        $this->createTable('{{%admin_users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull()->comment('用户名'),
            'password' => $this->string(64)->notNull()->comment('密码'),
            'real_name' => $this->string(50)->notNull()->comment('姓名'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0)->comment('状态0正常1禁用'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addCommentOnTable('{{%admin_users}}', '管理员表');
        $this->createIndex('idx_username', '{{%admin_users}}', 'username');

        # 菜单表，表结构
        $this->createTable('{{%admin_menus}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->notNull()->defaultValue(0)->comment('父ID'),
            'weight' => $this->integer()->notNull()->defaultValue(0)->comment('排序权重'),
            'name' => $this->string(50)->notNull()->comment('菜单名'),
            'icon' => $this->string(50)->notNull()->comment('菜单图标'),
            'uri' => $this->string()->notNull()->comment('菜单跳转地址'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0)->comment('状态0正常1隐藏'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addCommentOnTable('{{%admin_menus}}', '菜单表');
        $this->createIndex('idx_weight', '{{%admin_menus}}', 'weight');

        # 路由表，表结构
        $this->createTable('{{%admin_routes}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->comment('名称'),
            'route' => $this->string()->notNull()->comment('路由地址'),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0)->comment('状态0正常1禁用'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addCommentOnTable('{{%admin_routes}}', '路由表');

        # 角色表，表结构
        $this->createTable('{{%admin_roles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->comment('名称'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addCommentOnTable('{{%admin_roles}}', '角色表');

        # 用户角色表，表结构
        $this->createTable('{{%admin_user_role}}', [
            'user_id' => $this->integer()->notNull()->comment('管理员ID'),
            'role_id' => $this->integer()->notNull()->comment('角色ID'),
        ]);

        $this->addCommentOnTable('{{%admin_user_role}}', '用户角色表');
        $this->createIndex('idx_user_id', '{{%admin_user_role}}', 'user_id');

        # 角色菜单表，表结构
        $this->createTable('{{%admin_role_menu}}', [
            'role_id' => $this->integer()->notNull()->comment('角色ID'),
            'menu_id' => $this->integer()->notNull()->comment('菜单ID'),
        ]);

        $this->addCommentOnTable('{{%admin_role_menu}}', '角色菜单表');
        $this->createIndex('idx_role_id', '{{%admin_role_menu}}', 'role_id');

        # 权限表，表结构
        $this->createTable('{{%admin_permissions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull()->comment('名称'),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addCommentOnTable('{{%admin_permissions}}', '权限表');

        # 角色权限表，表结构
        $this->createTable('{{%admin_role_permission}}', [
            'role_id' => $this->integer()->notNull()->comment('角色ID'),
            'permission_id' => $this->integer()->notNull()->comment('权限ID'),
        ]);

        $this->addCommentOnTable('{{%admin_role_permission}}', '角色权限表');
        $this->createIndex('idx_role_id', '{{%admin_role_permission}}', 'role_id');

        # 权限路由表，表结构
        $this->createTable('{{%admin_permission_route}}', [
            'permission_id' => $this->integer()->notNull()->comment('权限ID'),
            'route_id' => $this->integer()->notNull()->comment('路由ID'),
        ]);

        $this->addCommentOnTable('{{%admin_permission_route}}', '权限路由表');
        $this->createIndex('idx_permission_id', '{{%admin_permission_route}}', 'permission_id');

        $this->createTable(
            '{{%admin_operation_logs}}',
            [
                'id' => $this->primaryKey(),
                'method' => $this->string(10)->notNull()->defaultValue('')->comment('请求方法'),
                'route' => $this->string(128)->notNull()->defaultValue('')->comment('请求路由'),
                'ip' => $this->string(60)->notNull()->defaultValue('')->comment('IP地址'),
                'params' => $this->text()->defaultValue(null)->comment('请求参数'),
                'created_by' => $this->integer()->notNull()->defaultValue(0)->comment('新增人id'),
                'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('新增时间'),
            ]
        );

        $this->createIndex('idx_created_at', '{{%admin_operation_logs}}', ['created_at']);
        $this->addCommentOnTable('{{%admin_operation_logs}}', '管理员操作日志表');
    }

    public function down()
    {
        $this->dropTable('{{%admin_users}}');
        $this->dropTable('{{%admin_menus}}');
        $this->dropTable('{{%admin_routes}}');
        $this->dropTable('{{%admin_roles}}');
        $this->dropTable('{{%admin_permissions}}');
        $this->dropTable('{{%admin_user_role}}');
        $this->dropTable('{{%admin_role_menu}}');
        $this->dropTable('{{%admin_role_permission}}');
        $this->dropTable('{{%admin_permission_route}}');
    }
}
