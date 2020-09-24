<？php
/**
 * Typecho博客平台
 *
 * @copyright版權所有（c）2008 Typecho團隊（http://www.typecho.org）
 * @許可證GNU通用公共許可證2.0
 * @version $ Id：index.php 1153 2009-07-02 10：53：22Z magike.net $
 */

/** 載入配置支持*/
如果（！defined（'__ TYPECHO_ROOT_DIR__'）&&！@include_once'config.inc.php'）{
    file_exists（'./ install.php'）嗎？header（'Location：install.php'）：print（'缺少配置文件'）;
    出口;
}

/** 初始化組件*/
Typecho_Widget ::小部件（'Widget_Init'）;

/** 註冊一個初始化插件*/
Typecho_Plugin :: factory（'index.php'）-> begin（）;

/** 開始路由分發*/
Typecho_Router :: dispatch（）;

/** 註冊一個結束插件*/
Typecho_Plugin :: factory（'index.php'）-> end（）;
