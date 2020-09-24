<？php if（！file_exists（dirname（__ FILE__）。'/ config.inc.php'））：？>
<？php
/ **
 * Typecho博客平台
 *
 * @copyright版權所有（c）2008 Typecho團隊（http://www.typecho.org）
 * @許可證GNU通用公共許可證2.0
 * @version $ Id $
 * /

/ **定義根目錄* /
define（'__ TYPECHO_ROOT_DIR__'，dirname（__ FILE__））;

/ **定義插件目錄（相對路徑）* /
define（'__ TYPECHO_PLUGIN_DIR__'，'/ usr / plugins'）;

/ **定義模板目錄（相對路徑）* /
define（'__ TYPECHO_THEME_DIR__'，'/ usr / themes'）;

/ **後台路徑（相對路徑）* /
define（'__ TYPECHO_ADMIN_DIR__'，'/ admin /'）;

/ **設置包含路徑* /
@set_include_path（get_include_path（）。PATH_SEPARATOR。
__TYPECHO_ROOT_DIR__。'/ var'。PATH_SEPARATOR。
__TYPECHO_ROOT_DIR__。__TYPECHO_PLUGIN_DIR__）;

/ **加載API支持* /
require_once'Typecho / Common.php';

/ **程序初始化* /
Typecho_Common :: init（）;

其他：

    require_once目錄名（__FILE__）。'/config.inc.php';

    //判斷是否已經安裝
    $ db = Typecho_Db :: get（）;
    嘗試{
        $ installed = $ db-> fetchRow（$ db-> select（）-> from（'table.options'）-> where（'name =？'，'installed'））;
        if（empty（$ installed）|| $ installed ['value'] == 1）{
            Typecho_Response :: setStatus（404）;
            出口;
        }
    } catch（Exception $ e）{
        // 沒做什麼
    }

萬一;

ob_start（）;

//擋掉可能的跨站請求
如果（！empty（$ _ GET）||！empty（$ _ POST））{
    如果（空（$ _SERVER ['HTTP_REFERER']））{
        出口;
    }

    $ parts = parse_url（$ _ SERVER ['HTTP_REFERER']）;
	如果（！empty（$ parts ['port']））{
        $ parts ['host'] =“ {$ parts ['host']}：{$ parts ['port']}”;
    }

    if（empty（$ parts ['host']）|| $ _SERVER ['HTTP_HOST']！= $ parts ['host']）{
        出口;
    }
}

/ **
 *獲取傳遞參數
 *
 * @param string $ name參數名稱
 * @param字符串$ default默認值
 * @返回字符串
 * /
函數_r（$ name，$ default = NULL）{
    返回isset（$ _ REQUEST [$ name]）嗎？
        （is_array（$ _ REQUEST [$ name]）？$ default：$ _REQUEST [$ name]）：$ default;
}

/ **
 *獲取多個傳遞參數
 *
 * @返回數組
 * /
函數_rFrom（）{
    $ result = array（）;
    $ params = func_get_args（）;

    foreach（$ params as $ param）{
        $ result [$ param] = isset（$ _ REQUEST [$ param]）嗎？
            （is_array（$ _ REQUEST [$ param]）？NULL：$ _REQUEST [$ param]）：NULL;
    }

    返回$ result;
}

/ **
 *輸出傳遞參數
 *
 * @param string $ name參數名稱
 * @param字符串$ default默認值
 * @返回字符串
 * /
函數_v（$ name，$ default =''）{
    迴聲_r（$ name，$ default）;
}

/ **
 *判斷是否兼容某個環境（執行）
 *
 * @param字符串$ adapter適配器
 * @返回布爾值
 * /
函數_p（$ adapter）{
    開關（$ adapter）{
        情況'Mysql'：
            返回Typecho_Db_Adapter_Mysql :: isAvailable（）;
        案例“ Mysqli”：
            返回Typecho_Db_Adapter_Mysqli :: isAvailable（）;
        情況'Pdo_Mysql'：
            返回Typecho_Db_Adapter_Pdo_Mysql :: isAvailable（）;
        情況“ SQLite”：
            返回Typecho_Db_Adapter_SQLite :: isAvailable（）;
        情況'Pdo_SQLite'：
            返回Typecho_Db_Adapter_Pdo_SQLite :: isAvailable（）;
        情況'Pgsql'：
            返回Typecho_Db_Adapter_Pgsql :: isAvailable（）;
        情況'Pdo_Pgsql'：
            返回Typecho_Db_Adapter_Pdo_Pgsql :: isAvailable（）;
        默認：
            返回false；
    }
}

/ **
 *獲取網址地址
 *
 * @返回字符串
 * /
函數_u（）{
    $ url = Typecho_Request :: getUrlPrefix（）。$ _SERVER ['REQUEST_URI'];
    如果（isset（$ _ SERVER ['QUERY_STRING']））{
        $ url = str_replace（'？'。$ _SERVER ['QUERY_STRING']，''，$ url）;
    }

    返回目錄名（$ url）;
}

$ options = new stdClass（）;
$ options-> generator ='Typecho'。Typecho_Common :: VERSION;
list（$ soft，$ currentVersion）= explode（''，$ options-> generator）;

$ options-> software = $ soft;
$ options-> version = $ currentVersion;

list（$ prefixVersion，$ suffixVersion）=爆炸（'/'，$ currentVersion）;

/ **獲取語言* /
$ lang = _r（'lang'，Typecho_Cookie :: get（'__ typecho_lang'））;
$ langs = Widget_Options_General :: getLangs（）;

if（empty（$ lang）||（！empty（$ langs）&&！isset（$ langs [$ lang]）））{
    $ lang ='zh_CN';
}

如果（'zh_CN'！= $ lang）{
    $ dir =定義（'__TYPECHO_LANG_DIR__'）？__TYPECHO_LANG_DIR__：__TYPECHO_ROOT_DIR__。'/ usr / langs';
    Typecho_I18n :: setLang（$ dir。'/'。$ lang。'.mo'）;
}

Typecho_Cookie :: set（'__ typecho_lang'，$ lang）;
？> <！DOCTYPE HTML>
<html xmlns =“ http://www.w3.org/1999/xhtml”>
<head lang =“ zh-CN”>
    <meta charset =“ <？php _e（'UTF-8'）;？>” />
	<title> <？php _e（'Typecho安裝程序'）; ？> </ title>
    <link rel =“ stylesheet” type =“ text / css” href =“ admin / css / normalize.css” />
    <link rel =“ stylesheet” type =“ text / css” href =“ admin / css / grid.css” />
    <link rel =“ stylesheet” type =“ text / css” href =“ admin / css / style.css” />
</ head>
<身體>
<div class =“ typecho-install-patch”>
    <h1> Typecho </ h1>
    <ol class =“ path”>
        <li <？php if（！isset（$ _ GET ['finish']）&&！isset（$ _ GET ['config']））：？> class =“ current” <？php endif; ？>> <span> 1 </ span> <？php _e（'歡迎使用'）; ？> </ li>
        <li <？php if（isset（$ _ GET ['config']））：：> class =“ current” <？php endif; ？>> <span> 2 </ span> <？php _e（'初始化配置'）; ？> </ li>
        <li <？php if（isset（$ _ GET ['start']））：？> class =“ current” <？php endif; ？>> <span> 3 </ span> <？php _e（'開始安裝'）; ？> </ li>
        <li <？php if（isset（$ _ GET ['finish']）））：？> class =“ current” <？php endif; ？>> <span> 4 </ span> <？php _e（'安裝成功'）; ？> </ li>
    </ ol>
</ div>
<div class =“ container”>
    <div class =“ row”>
        <div class =“ col-mb-12 col-tb-8 col-tb-offset-2”>
            <div class =“ column-14 start-06 typecho-install”>
            <？php if（isset（$ _ GET ['finish']））：？>
                <？php if（！isset（$ db））：？>
                <h1 class =“ typecho-install-title”> <？php _e（'安裝失敗！'）; ？> </ h1>
                <div class =“ typecho-install-body”>
                    <form method =“ post” action =“？config” name =“ config”>
                    <p class =“ message error”> <？php _e（'您沒有上傳config.inc.php文件，請您重新安裝！'）; ？> <button class =“ btn primary” type =“ submit”> <？php _e（'重新安裝＆raquo;'）; ？> </ button> </ p>
                    </ form>
                </ div>
                <？php elseif（！Typecho_Cookie :: get（'__ typecho_config'））：？>
                    <h1 class =“ typecho-install-title”> <？php _e（'沒有安裝！'）; ？> </ h1>
                    <div class =“ typecho-install-body”>
                        <form method =“ post” action =“？config” name =“ config”>
                            <p class =“ message error”> <？php _e（'您沒有執行安裝步驟，請您重新安裝！'）; ？> <button class =“ btn primary” type =“ submit”> <？php _e（'重新安裝＆raquo;'）; ？> </ button> </ p>
                        </ form>
                    </ div>
                <？php else：？>
                    <？php
                    $ db-> query（$ db-> update（'table.options'）-> rows [['value'=> 1]）-> where（'name =？'，'installed'））;
                    ？>
                <h1 class =“ typecho-install-title”> <？php _e（'安裝成功！'）; ？> </ h1>
                <div class =“ typecho-install-body”>
                    <div class =“ message success”>
                    <？php if（isset（$ _ GET ['use_old']））：？>
                    <？php _e（'您選擇了使用初始的數據，您的用戶名和密碼和原來的一致'）; ？>
                    <？php else：？>
                        <？php if（isset（$ _ REQUEST ['user']）&& isset（$ _ REQUEST ['password']））：？>
                            <？php _e（'您的用戶名是'）; ？>：<strong class =“ mono”> <？php echo htmlspecialchars（_r（'user'））; ？> </ strong> <br>
                            <？php _e（'您的密碼是'）; ？>：<strong class =“ mono”> <？php echo htmlspecialchars（_r（'password'））; ？> </ strong>
                        <？php endif;？>
                    <？php endif;？>
                    </ div>

                    <div class =“ p郵件通知”>
                    <a target="_blank" href="http://spreadsheets.google.com/viewform?key=pd1Gl4Ur_pbniqgebs5JRIg&hl=en">參與用戶調查，幫助我們完善產品</a>
                    </ div>

                    <div class =“ session”>
                    <p> <？php _e（'您可以將以下兩個鏈接保存到您的收藏夾'）; ？>：</ p>
                    <ul>
                    <？php
                        if（isset（$ _ REQUEST ['user']）&& isset（$ _ REQUEST ['password']））{
                            $ loginUrl = _u（）。'/index.php/action/login?name='。urlencode（_r（'user'））。'＆password ='
                            。urlencode（_r（'password'））。'＆referer ='。_u（）。'/admin/index.php';
                            $ loginUrl = Typecho_Widget :: widget（'Widget_Security'）-> getTokenUrl（$ loginUrl）;
                        }其他{
                            $ loginUrl = _u（）。'/admin/index.php';
                        }
                    ？>
                        <li> <a href="<?php echo $loginUrl; ?>“> <？php _e（'點擊此處訪問您的控制面板'）; ？> </a> </ li>
                        <li> <a href="<?php echo _u(); ?> /index.php"><?php _e（'點擊這裡查看您的博客'）; ？> </a> </ li>
                    </ ul>
                    </ div>

                    <p> <？php _e（'希望您能替換適合Typecho帶來的樂趣！'）; ？> </ p>
                </ div>
                <？php endif;？>
            <？php elseif（isset（$ _ GET ['start']））：？>
                <？php if（！isset（$ db））：？>
                <h1 class =“ typecho-install-title”> <？php _e（'安裝失敗！'）; ？> </ h1>
                <div class =“ typecho-install-body”>
                    <form method =“ post” action =“？config” name =“ config”>
                    <p class =“ message error”> <？php _e（'您沒有上傳config.inc.php文件，請您重新安裝！'）; ？> <button class =“ btn primary” type =“ submit”> <？php _e（'重新安裝＆raquo;'）; ？> </ button> </ p>
                    </ form>
                </ div>
                <？php else：？>
            <？php
                                    $ config =反序列化（base64_decode（Typecho_Cookie :: get（'__ typecho_config'）））;;
                                    $ type = explode（'_'，$ config ['adapter']）;
                                    $ type = array_pop（$ type）;
                                    $ type = $ type =='Mysqli'嗎？'Mysql'：$類型;
                                    $ installDb = $ db;

                                    嘗試{
                                        / **初始化數據庫結構* /
                                        $ scripts = file_get_contents（'./install/'。$ type。'.sql'）;
                                        $ scripts = str_replace（'typecho_'，$ config ['prefix']，$ scripts）;

                                        如果（isset（$ config ['charset']））{
                                            $ scripts = str_replace（'％charset％'，$ config ['charset']，$ scripts）;
                                        }

                                        如果（isset（$ config ['engine']））{
                                            $ scripts = str_replace（'％engine％'，$ config ['engine']，$ scripts）;
                                        }

                                        $ scripts = explode（';'，$ scripts）;
                                        foreach（將$ scripts作為$ script）{
                                            $ script = trim（$ script）;
                                            如果（$ script）{
                                                $ installDb-> query（$ script，Typecho_Db :: WRITE）;
                                            }
                                        }

                                        / **變量變量* /
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'theme'，'user'=> 0，'value'=>'default'）） ）;
                                        $ installDb->查詢（$ installDb->插入（'table.options'）->行（array（'name'=>'theme：default'，'user'=> 0，'value'=>'a： 2：{s：7：“ logoUrl”; N; s：12：“ sidebarBlock”; a：5：{i：0; s：15：“ ShowRecentPosts”; i：1; s：18：“ ShowRecentComments”; i：2; s：12：“ ShowCategory”; i：3; s：11：“ ShowArchive”; i：4; s：9：“ ShowOther”;}}'）））））
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'timezone'，'user'=> 0，'value'=> _t（'28800' ））））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'lang'，'user'=> 0，'value'=> $ lang））） ;
                                        $ installDb->查詢（$ installDb->插入（'table.options'）->行（array（'name'=>'charset'，'user'=> 0，'value'=> _t（'UTF- 8'））））;
                                        $ installDb->查詢（$ installDb->插入（'table.options'）->行（array（'name'=>'contentType'，'user'=> 0，'value'=>'text / html' ）））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'gzip'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）->行（array（'name'=>'generator'，'user'=> 0，'value'=> $ options-> generator ）））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'title'，'user'=> 0，'value'=>'Hello World'） ））；
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'description'，'user'=> 0，'value'=>'Just So So。 ..'）））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'keywords'，'user'=> 0，'value'=>'typecho，php，博客'）））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'rewrite'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb->查詢（$ installDb->插入（'table.options'）->行（array（'name'=>'frontPage'，'user'=> 0，'value'=>'recent'）） ）;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'frontArchive'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsRequireMail'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsWhitelist'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsRequireURL'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsRequireModeration'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'plugins'，'user'=> 0，'value'=>'a：0： {}'）））；
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentDateFormat'，'user'=> 0，'value'=>'F jS，Y \ a \ th：i a'）））；
                                        $ installDb->查詢（$ installDb->插入（'table.options'）->行（array（'name'=>'siteUrl'，'user'=> 0，'value'=> $ config ['siteUrl ']）））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'defaultCategory'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'allowRegister'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'defaultAllowComment'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'defaultAllowPing'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'defaultAllowFeed'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'pageSize'，'user'=> 0，'value'=> 5））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'postsListSize'，'user'=> 0，'value'=> 10））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsListSize'，'user'=> 0，'value'=> 10））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsHTMLTagAllowed'，'user'=> 0，'value'=> NULL）））;;
                                        $ installDb->查詢（$ installDb->插入（'table.options'）->行（array（'name'=>'postDateFormat'，'user'=> 0，'value'=>'Ym-d' ）））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'feedFullText'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'editorSize'，'user'=> 0，'value'=> 350））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'autoSave'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'markdown'，'user'=> 0，'value'=> 1））））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'xmlrpcMarkdown'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsMaxNestingLevels，'user'=> 0，'value'=> 5））））;;
                                        $ installDb->查詢（$ installDb->插入（'table.options'）->行（array（'name'=>'commentsPostTimeout'，'user'=> 0，'value'=> 24 * 3600 * 30 ）））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsUrlNofollow'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsShowUrl'，'user'=> 0，'value'=> 1））））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsMarkdown'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsPageBreak'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsThreaded'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsPageSize'，'user'=> 0，'value'=> 20））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）->行（array（'name'=>'commentsPageDisplay'，'user'=> 0，'value'=>'last'）） ）;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）->行（array（'name'=>'commentsOrder'，'user'=> 0，'value'=>'ASC'）） ）;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsCheckReferer'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsAutoClose'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsPostIntervalEnable'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsPostInterval'，'user'=> 0，'value'=> 60））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsShowCommentOnly'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsAvatar'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsAvatarRating'，'user'=> 0，'value'=>'G'）） ）;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'commentsAntiSpam'，'user'=> 0，'value'=> 1））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'routingTable'，'user'=> 0，'value'=>'a：25： {s：5：“索引”; a：3：{s：3：“ url”; s：1：“ /”; s：6：“小部件”; s：14：“ Widget_Archive”; s：6： “ action”; s：6：“ render”;} s：7：“ archive”; a：3：{s：3：“ url”; s：6：“ / blog /”; s：6：“ widget “; s：14：” Widget_Archive“; s：6：” action“; s：6：” render“;} s：2：” do“; a：3：{s：3：” url“; s： 22：“ / action / [action：alpha]”; s：6：“ widget”; s：9：“ Widget_Do”; s：6：“ action”; s：6：“ action”;} s：4： “ post”; a：3：{s：3：“ url”; s：24：“ / archives / [cid：digital] /”; s：6：“ widget”; s：14：“ Widget_Archive”; s：6：“ action”; s：6：“ render”;} s：10：“ attachment”; a：3：{s：3：“ url”; s：26：“ /附件/ [cid：數字] /“; s：6：”小部件“; s：14：” Widget_Archive“; s：6：”動作“; s：6：”渲染“;} s：8：”類別“ ; a：3：{s：3：“ url”; s：17：“ / category / [slug] /”; s：6：“ widget”; s：14：“ Widget_Archive”; s：6：“ action “; s：6：” render“;} s：3：” tag“; a：3：{s：3：” url“; s：12：” / tag / [slug] /“; s：6： “ widget”; s：14：“ Widget_Archive”; s：6：“ action”; s：6：“ render”;} s：6：“ author”; a：3：{s：3：“ url”; s：22：“ / author / [uid：digital] /”; s：6：“ widget”; s：14：“ Widget_Archive”; s：6：“ action”; s：6：“ render”;} s ：6：“搜索”; a：3：{s：3：“ url”; s：19：“ / search / [關鍵字] /”; s：6：“ widget”; s：14：“ Widget_Archive”; s：6：“ action”; s：6：“渲染“;} s：10：” index_page“; a：3：{s：3：” url“; s：21：” / page / [page：digital] /“; s：6：” widget“; s： 14：“ Widget_Archive”; s：6：“ action”; s：6：“ render”;} s：12：“ archive_page”; a：3：{s：3：“ url”; s：26：“ / blog / page / [page：digital] /“; s：6：” widget“; s：14：” Widget_Archive“; s：6：” action“; s：6：” render“;} s：13：” category_page“; a：3：{s：3：” url“; s：32：” / category / [slug] / [page：digital] /“; s：6：” widget“; s：14：” Widget_Archive “; s：6：” action“; s：6：” render“;} s：8：” tag_page“; a：3：{s：3：” url“; s：27：” / tag / [slug ] / [page：digital] /“; s：6：“ widget”; s：14：“ Widget_Archive”; s：6：“ action”; s：6：“ render”;} s：11：“ author_page”; a：3：{s：3：“ url”; s：37：“ / author / [uid：digital] / [page：digital] /”; s：6：“ widget”; s：14：“ Widget_Archive”; s：6：“ action”; s：6： “ render”;} s：11：“ search_page”; a：3：{s：3：“ url”; s：34：“ / search / [關鍵字] / [page：digital] /”; s：6： “ widget”; s：14：“ Widget_Archive”; s：6：“ action”; s：6：“ render”;} s：12：“ archive_year”; a：3：{s：3：“ url”; s：18：“ / [year：digital：4] /”; s：6：“ widget”; s：14：“ Widget_Archive”; s：6：“ action”; s：6：“ render”;} s ：13：“ archive_month”; a：3：{s：3：“ url”; s：36：“ / [year：digital：4] / [month：digital：2] /”; s：6：“ widget “; s：14：”Widget_Archive“; s：6：” action“; s：6：” render“;} s：11：” archive_day“; a：3：{s：3：” url“; s：52：” / [年份： digital：4] / [month：digital：2] / [day：digital：2] /“; s：6：”小工具“; s：14：” Widget_Archive“; s：6：”動作“; s：6 ：“ render”;} s：17：“ archive_year_page”; a：3：{s：3：“ url”; s：38：“ / [year：digital：4] / page / [page：digital] /” ; s：6：“ widget”; s：14：“ Widget_Archive”; s：6：“ action”; s：6：“ render”;} s：18：“ archive_month_page”; a：3：{s：3 ：“ url”; s：56：“ / [年：數字：4] / [月：數字：2] / page / [頁面：數字] /”; s：6：“小部件”; s：14：“ Widget_Archive“; s：6：” action“; s：6：” render“;} s：16：” archive_day_page“; a：3：{s：3：” url“; s：72：” / [年份：數字：4] / [月：數字：2] / [天：digital：2] / page / [page：digital] /“; s：6：” widget“; s：14：” Widget_Archive“; s：6：” action“; s：6：” render“;} s： 12：“ comment_page”; a：3：{s：3：“ url”; s：53：“ [permalink：string] / comment-page- [commentPage：digital]”; s：6：“ widget”; s ：14：“ Widget_Archive”; s：6：“ action”; s：6：“ render”;} s：4：“ feed”; a：3：{s：3：“ url”; s：20：“ / feed [feed：string：0]“; s：6：” widget“; s：14：” Widget_Archive“; s：6：” action“; s：4：” feed“;} s：8：”反饋“; a：3：{s：3：” url“; s：31：” [永久鏈接：字符串] / [類型：alpha]“; s：6：”小部件“; s：15：” Widget_Feedback“; s ：6：“ action”; s：6：“ action”;} s：4：“ page”; a：3：{s：3：“ url”; s：12：“ / [slug] .html”; s：6：“小部件”; s：14：“ Widget_Archive”; s：6：“ action”; s：6：“ render”;}}'））））;
                                        $ installDb->查詢（$ installDb->插入（'table.options'）->行（array（'name'=>'actionTable'，'user'=> 0，'value'=>'a：0： {}'）））；
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'panelTable'，'user'=> 0，'value'=>'a：0： {}'）））；
                                        $ installDb->查詢（$ installDb->插入（'table.options'）->行（array（'name'=>'attachmentTypes'，'user'=> 0，'value'=>'@ image @' ）））;
                                        $ installDb->查詢（$ installDb->插入（'table.options'）->行（array（'name'=>'secret'，'user'=> 0，'value'=> Typecho_Common :: randString（ 32，true））））;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'installed'，'user'=> 0，'value'=> 0））））;;
                                        $ installDb-> query（$ installDb-> insert（'table.options'）-> rows（array（'name'=>'allowXmlRpc'，'user'=> 0，'value'=> 2））））;;

                                        / **初始分類* /
                                        $ installDb-> query（$ installDb-> insert（'table.metas'）->行（array（'name'=> _t（'分類分類'），'slug'=>'default'，'type'= >'類別'，'描述'=> _t（'只是一個類別分類'），
                                        'count'=> 1，'order'=> 1））））;

                                        / **初始關係* /
                                        $ installDb-> query（$ installDb-> insert（'table.relationships'）-> rows（array（'cid'=> 1，'mid'=> 1）））;;

                                        / **初始內容* /
                                        $ installDb-> query（$ installDb-> insert（'table.contents'）-> rows（array（'title'=> _t（'歡迎使用Typecho'），'slug'=>'start'，'created' => Typecho_Date :: time（），“已修改” => Typecho_Date :: time（），
                                        'text'=>'<！-markdown->'。_t（'如果您看到這篇文章，表示您的博客已經安裝成功。'），'authorId'=> 1，'type'=>'post'，'status'=>'publish'，'commentsNum' => 1，'allowComment'=> 1，
                                        'allowPing'=> 1，'allowFeed'=> 1，'父母'=> 0）））;

                                        $ installDb->查詢（$ installDb->插入（'table.contents'）->行（array（'title'=> _t（'關於'），'slug'=>'起始頁'，'創建的' => Typecho_Date :: time（），“已修改” => Typecho_Date :: time（），
                                        'text'=>'<！-markdown->'。_t（'本頁面由Typecho創建，這只是一個測試頁面。'），'authorId'=> 1，'order'=> 0，'type'=>'page'，'status'=>'publish'， 'commentsNum'=> 0，'allowComment'=> 1，
                                        'allowPing'=> 1，'allowFeed'=> 1，'父母'=> 0）））;

                                        / **初始評論* /
                                        $ installDb-> query（$ installDb-> insert（'table.comments'）-> rows（array（'cid'=> 1，'created'=> Typecho_Date :: time（），'author'=>'Typecho '，'ownerId'=> 1，'url'=>'http://typecho.org'，
                                        'ip'=>'127.0.0.1'，'agent'=> $ options-> generator，'text'=>'歡迎加入Typecho大家族'，'type'=>'comment'，'status'=>'已批准'，'父母'=> 0）））;

                                        / **初始用戶* /
                                        $ password = empty（$ config ['userPassword']）嗎？substr（uniqid（），7）：$ config ['userPassword'];
                                        $ hasher = new PasswordHash（8，true）;

                                        $ installDb->查詢（$ installDb->插入（'table.users'）->行（array（'name'=> $ config ['userName']，'password'=> $ hasher-> HashPassword（$ password ），'mail'=> $ config ['userMail']，
                                        'url'=>'http://www.typecho.org'，'screenName'=> $ config ['userName']，'group'=>'administrator'，'created'=> Typecho_Date :: time（） ）））;

                                        未設置（$ _SESSION ['typecho']）;
                                        header（'Location：./install.php?finish&user='。urlencode（$ config ['userName']）
                                            。'＆password ='。urlencode（$ password））;
                                    } catch（Typecho_Db_Exception $ e）{
                                        $成功=假;
                                        $ code = $ e-> getCode（）;
？>
<h1 class =“ typecho-install-title”> <？php _e（'安裝失敗！'）; ？> </ h1>
                <div class =“ typecho-install-body”>
                    <form method =“ post” action =“？start” name =“ check”>
<？php
                                        if（（''Mysql'== $ type &&（1050 == $ code ||'42S01'== $ code））||
                                        （'SQLite'== $ type &&（'HY000'== $ code || 1 == $ code））||
                                        （'Pgsql'== $ type &&'42P07'== $ code））{
                                            if（_r（'delete'））{
                                                //刪除原始數據
                                                $ dbPrefix = $ config ['prefix'];
                                                $ tableArray = array（$ dbPrefix。'comments'，$ dbPrefix。'contents，$ dbPrefix。'fields'，$ dbPrefix。'metas'，$ dbPrefix。'options'，$ dbPrefix。'relationships'，$ dbPrefix。 “用戶”，）；
                                                foreach（$ tableArray as $ table）{
                                                    if（$ type =='Mysql'）{
                                                        $ installDb-> query（“如果存在表{{$ table}`”，則刪除表）；
                                                    } elseif（$ type =='Pgsql'）{
                                                        $ installDb-> query（“ DROP TABLE {$ table}”）;
                                                    } elseif（$ type =='SQLite'）{
                                                        $ installDb-> query（“ DROP TABLE {$ table}”）;
                                                    }
                                                }
                                                迴聲'<p class =“ message success”>'。_t（'已經刪除完內置數據'）。'<br /> <br /> <button class =“ btn primary” type =“ submit” class =“ primary”>'
                                                    。_t（'繼續安裝＆raquo;'）。'</ button> </ p>';
                                            } elseif（_r（'goahead'））{
                                                //使用內置數據
                                                //但是要更新用戶網站
                                                $ installDb->查詢（$ installDb-> update（'table.options'）->行（array（'value'=> $ config ['siteUrl']））-> where（'name =？'，'siteUrl '））;
                                                未設置（$ _SESSION ['typecho']）;
                                                header（'Location：./install.php?finish&use_old'）;
                                                出口;
                                            }其他{
                                                 迴聲'<p class =“ message error”>'。_t（'安裝程序檢查到內置數據表已經存在。'）
                                                    。'<br /> <br />'。'<button type =“提交” name =“刪除” value =“ 1” class =“ btn btn-warn”>'。_t（'刪除預設數據'）。'</ button>'
                                                    。_t（'或者'）。'<button type =“ submit” name =“ goahead” value =“ 1” class =“ btn primary”>'。_t（'使用常規數據'）。'</ button> </ p>';
                                            }
                                        }其他{
                                            迴聲'<p class =“ message error”>'。_t（'安裝程序捕捉到以下錯誤：“％s”。程序被終止，請檢查您的配置信息。'，$ e-> getMessage（））。'</ p>';
                                        }
                                        ？>
                    </ form>
                </ div>
                                        <？php
                                    }
            ？>
                <？php endif;？>
            <？php elseif（isset（$ _ GET ['config']））：？>
            <？php
                    $ adapters = array（'Mysql'，'Mysqli'，'Pdo_Mysql'，'SQLite'，'Pdo_SQLite'，'Pgsql'，'Pdo_Pgsql'）;
                    foreach（$ adapters as $ firstAdapter）{
                        如果（_p（$ firstAdapter））{
                            打破;
                        }
                    }
                    $ adapter = _r（'dbAdapter'，$ firstAdapter）;
                    $ parts = explode（'_'，$ adapter）;

                    $ type = $適配器=='Mysqli'？'Mysql'：array_pop（$ parts）;
            ？>
                <form method =“ post” action =“？config” name =“ config”>
                    <h1 class =“ typecho-install-title”> <？php _e（'確認您的配置'）; ？> </ h1>
                    <div class =“ typecho-install-body”>
                        <h2> <？php _e（'數據庫配置'）; ？> </ h2>
                        <？php
                            如果（'config'== _r（'action'））{
                                $ success = true;

                                如果（_r（'created'）&&！file_exists（'./ config.inc.php'））{
                                    迴聲'<p class =“ message error”>'。_t（'沒有檢測到您手動創建的配置文件，請檢查後再次創建'）。'</ p>';
                                    $成功=假;
                                }其他{
                                    如果（NULL == _r（'userUrl'））{
                                        $成功=假;
                                        迴聲'<p class =“ message error”>'。_t（'請填寫您的網站地址'）。'</ p>';
                                    } else if（NULL == _r（'userName'））{
                                        $成功=假;
                                        迴聲'<p class =“ message error”>'。_t（'請填寫您的用戶名'）。'</ p>';
                                    } else if（NULL == _r（'userMail'））{
                                        $成功=假;
                                        迴聲'<p class =“ message error”>'。_t（'請填寫您的郵箱地址'）。'</ p>';
                                    } else if（32 <strlen（_r（'userName'）））{
                                        $成功=假;
                                        迴聲'<p class =“ message error”>'。_t（'用戶名長度超過限制，請不要超過32個字符'）。'</ p>';
                                    } else if（200 <strlen（_r（'userMail'）））{
                                        $成功=假;
                                        迴聲'<p class =“ message error”>'。_t（'郵箱長度超過限制，請不要超過200個字符'）。'</ p>';
                                    }
                                }

                                $ _dbConfig = _rFrom（'dbHost'，'dbUser'，'dbPassword'，'dbCharset'，'dbPort'，'dbDatabase'，'dbFile'，'dbDsn'，'dbEngine'）;

                                $ _dbConfig = array_filter（$ _ dbConfig）;
                                $ dbConfig = array（）;
                                foreach（$ _dbConfig as $ key => $ val）{
                                    $ dbConfig [strtolower（substr（$ key，2））] = $ val;
                                }

                                //在特殊服務器上的特殊安裝過程處理
                                如果（_r（'config'））{
                                    $ replace = array_keys（$ dbConfig）;
                                    foreach（$ replace as＆$ key）{
                                        $ key ='{'。$ key。'}';
                                    }

                                    如果（！empty（$ _ dbConfig ['dbDsn']））{
                                        $ dbConfig ['dsn'] = str_replace（$ replace，array_values（$ dbConfig），$ dbConfig ['dsn']）;
                                    }
                                    $ config = str_replace（$ replace，array_values（$ dbConfig），_r（'config'））;
                                }

                                如果（！isset（$ config）&& $ success &&！_r（'created'））{
                                    $ installDb =新的Typecho_Db（$ adapter，_r（'dbPrefix'））;
                                    $ installDb-> addServer（$ dbConfig，Typecho_Db :: READ | Typecho_Db :: WRITE）;


                                    / **檢測數據庫配置* /
                                    嘗試{
                                        $ installDb-> query（'SELECT 1 = 1'）;
                                    } catch（Typecho_Db_Adapter_Exception $ e）{
                                        $成功=假;
                                        回顯'<p class =“ message error”>'
                                        。_t（'對不起，無法連接數據庫，請先檢查數據庫配置再繼續進行安裝'）。'</ p>';
                                    } catch（Typecho_Db_Exception $ e）{
                                        $成功=假;
                                        回顯'<p class =“ message error”>'
                                        。_t（'安裝程序捕捉到以下錯誤：“％s”。程序被終止，請檢查您的配置信息。'，$ e-> getMessage（））。'</ p>';
                                    }
                                }

                                if（$ success）{
                                    //重置初始化數據庫狀態
                                    如果（isset（$ installDb））{
                                        嘗試{
                                            $ installDb->查詢（$ installDb-> update（'table.options'）
                                                ->行（array（'value'=> 0））-> where（'name =？'，'已安裝'））;
                                        } catch（Exception $ e）{
                                            // 沒做什麼
                                        }
                                    }

                                    Typecho_Cookie :: set（'__ typecho_config'，base64_encode（serialize（array_merge（array（
                                        '前綴'=> _r（'dbPrefix'），
                                        '用戶名'=> _r（'用戶名'），
                                        'userPassword'=> _r（'userPassword'），
                                        'userMail'=> _r（'userMail'），
                                        '適配器'=> $適配器，
                                        'siteUrl'=> _r（'userUrl'）
                                    ），$ dbConfig））））;

                                    如果（_r（'created'））{
                                        header（'Location：./install.php?start'）;
                                        出口;
                                    }

                                    / **初始化配置文件* /
                                    $ lines = array_slice（file（__ FILE__），1，31）;
                                    $ lines [] =“
/ **定義數據庫參數* /
\ $ db = new Typecho_Db（'{$ adapter}'，'“。_r（'dbPrefix'）。”'）;
\ $ db-> addServer（“。（empty（$ config）？var_export（$ dbConfig，true）：$ config）。”，Typecho_Db :: READ | Typecho_Db :: WRITE）;
Typecho_Db :: set（\ $ db）;
“;
                                    $ contents = implode（''，$ lines）;
                                    如果（！Typecho_Common :: isAppEngine（））{
                                        @file_put_contents（'./ config.inc.php'，$ contents）;
                                    }

                                    如果（！file_exists（'./ config.inc.php'））{
                                    ？>
<div class =“ message notice”> <p> <？php _e（'安裝程序無法自動創建<strong> config.inc.php </ strong>文件'）; ？> <br />
<？php _e（'您可以在網站根目錄下手動創建<strong> config.inc.php </ strong>文件，並複制如下代碼至其中'）; ？> </ p>
<p> <textarea rows =“ 5” onmouseover =“ this.select（）;” class =“ w-100 mono” readonly> <？php echo htmlspecialchars（$ contents）; ？> </ textarea> </ p>
<p> <button name =“ created” value =“ 1” type =“ submit” class =“ btn primary”> <？php _e（'創建完成，繼續安裝＆raquo;'）; ？> </ button> </ p> </ div>
                                    <？php
                                    }其他{
                                        header（'Location：./install.php?start'）;
                                        出口;
                                    }
                                }

                                //安裝不成功刪除配置文件
                                if（！$ success && file_exists（__ TYPECHO_ROOT_DIR__。'/config.inc.php'））{
                                    @unlink（__ TYPECHO_ROOT_DIR__。'/ config.inc.php'）;
                                }
                            }
                        ？>
                        <ul class =“ typecho-option”>
                            <li>
                            <label for =“ dbAdapter” class =“ typecho-label”> <？php _e（'數據庫適配器'）; ？> </ label>
                            <select name =“ dbAdapter” id =“ dbAdapter”>
                                <？php if（_p（'Mysql'））：？> <選項value =“ Mysql” <？php if（'Mysql'== $ adapter）：？> selected =“ selected” <？php endif; ？>> <？php _e（'Mysql原生函數適配器'）？> </ option> <？php endif; ？>
                                <？php if（_p（'SQLite'））：？> <選項value =“ SQLite” <？php if（'SQLite'== $ adapter）：？> selected =“ selected” <？php endif; ？>> <？php _e（'SQLite原生函數適配器（SQLite 2.x）'）？> </ option> <？php endif; ？>
                                <？php if（_p（'Pgsql'））：？> <選項value =“ Pgsql” <？php if（'Pgsql'== $ adapter）：？> selected =“ selected” <？php endif; ？>> <？php _e（'Pgsql原生函數適配器'）？> </ option> <？php endif; ？>
                                <？php if（_p（'Pdo_Mysql'））：？> <option value =“ Pdo_Mysql” <？php if（'Pdo_Mysql'== $ adapter）：？> selected =“ selected” <？php endif; ？>> <？php _e（'Pdo驅動Mysql適配器'）？> </ option> <？php endif; ？>
                                <？php if（_p（'Pdo_SQLite'））：？> <option value =“ Pdo_SQLite” <？php if（'Pdo_SQLite'== $ adapter）：？> selected =“ selected” <？php endif; ？>> <？php _e（'Pdo驅動SQLite適配器（SQLite 3.x）'）？> </ option> <？php endif; ？>
                                <？php if（_p（'Pdo_Pgsql'））：？> <option value =“ Pdo_Pgsql” <？php if（'Pdo_Pgsql'== $ adapter）：？> selected =“ selected” <？php endif; ？>> <？php _e（'Pdo驅動PostgreSql適配器'）？> </ option> <？php endif; ？>
                            </ select>
                            <p class =“ description”> <？php _e（'請根據您的數據庫類型選擇合適的適配器'）; ？> </ p>
                            </ li>
                            <？php require_once'./install/'。$ type。'.php'; ？>
                            <li>
                            <label class =“ typecho-label” for =“ dbPrefix”> <？php _e（'數據庫鏈接'）; ？> </ label>
                            <input type =“ text” class =“ text” name =“ dbPrefix” id =“ dbPrefix” value =“ <？php _v（'dbPrefix'，'typecho_'）;？>” />
                            <p class =“ description”> <？php _e（'交替插入是“ typecho_”'）; ？> </ p>
                            </ li>
                        </ ul>

                        <腳本>
                        var _select = document.config.dbAdapter;
                        _select.onchange = function（）{
                            setTimeout（“ window.location.href ='install.php？config＆dbAdapter =” + this.value +“';”，0）;
                        }
                        </ script>

                        <h2> <？php _e（'創建您的管理員帳號'）; ？> </ h2>
                        <ul class =“ typecho-option”>
                            <li>
                            <label class =“ typecho-label” for =“ userUrl”> <？php _e（'網站地址'）; ？> </ label>
                            <input type =“ text” name =“ userUrl” id =“ userUrl” class =“ text” value =“ <？php _v（'userUrl'，_u（））;？>” />
                            <p class =“ description”> <？php _e（'這是程序自動匹配的網站路徑，如果不正確請修改它'）; ？> </ p>
                            </ li>
                            <li>
                            <label class =“ typecho-label” for =“ userName”> <？php _e（'用戶名'）; ？> </ label>
                            <input type =“ text” name =“ userName” id =“ userName” class =“ text” value =“ <？php _v（'userName'，'admin'）;？>” />
                            <p class =“ description”> <？php _e（'請填寫您的用戶名'）; ？> </ p>
                            </ li>
                            <li>
                            <label class =“ typecho-label” for =“ userPassword”> <？php _e（'登錄密碼'）; ？> </ label>
                            <input type =“ password” name =“ userPassword” id =“ userPassword” class =“ text” value =“ <？php _v（'userPassword'）;？>” />
                            <p class =“ description”> <？php _e（'請填寫您的登錄密碼，如果留空系統將為您隨機生成一個'）; ？> </ p>
                            </ li>
                            <li>
                            <label class =“ typecho-label” for =“ userMail”> <？php _e（'郵件地址'）; ？> </ label>
                            <input type =“ text” name =“ userMail” id =“ userMail” class =“ text” value =“ <？php _v（'userMail'，'webmaster@yourdomain.com'）;？>” />
                            <p class =“ description”> <？php _e（'請填寫一個您的常用郵箱'）; ？> </ p>
                            </ li>
                        </ ul>
                    </ div>
                    <input type =“ hidden” name =“ action” value =“ config” />
                    <p class =“ submit”> <button type =“ submit” class =“ btn primary”> <？php _e（'確認，開始安裝＆raquo;'）; ？> </ button> </ p>
                </ form>
            <？php else：？>
                <form method =“ post” action =“？config”>
                <h1 class =“ typecho-install-title”> <？php _e（'歡迎使用Typecho'）; ？> </ h1>
                <div class =“ typecho-install-body”>
                <h2> <？php _e（'安裝說明'）; ？> </ h2>
                <p> <strong> <？php _e（'本安裝程序將自動檢測服務器環境是否符合最低配置需求。如果不符合，將在上方出現提示信息，請按照提示信息檢查您的主機配置。如果服務器環境符合要求，將在下方出現“開始下一步”的按鈕，點擊此按鈕即可一步完成安裝。？> </ strong> </ p>
                <h2> <？php _e（'許可及協議'）; ？> </ h2>
                <p> <？php _e（'Typecho基於<a href =“ http://www.gnu.org/copyleft/gpl.html”> GPL </a>協議發布，我們允許用戶在GPL協議允許的範圍內內使用，副本，修改和分發此程序。？>
                <？php _e（'在GPL授權的範圍內，您可以自由地將其用於商業以及非商業用途。'）; ？> </ p>
                <p> <？php _e（“ Typecho軟件由其社區提供支持，核心開發團隊負責維護程序日常開發工作以及新特性的製定。”）；？>
                <？php _e（'如果您遇到使用上的問題，程序中的BUG，以及期許的新功能，歡迎您在社區中交流或者直接向我們貢獻的代碼。'）；？>
                <？php _e（'對於貢獻突出者，他的名字將出現在貢獻者列表中。'）; ？> </ p>
                </ div>
                <p class =“ submit”>
                    <button type =“ submit” class =“ btn primary”> <？php _e（'我準備好了，開始下一步＆raquo;'）; ？> </ button>

                    <？php if（count（$ langs）> 1）：？>
                    <select style =“ float：right” onchange =“ window.location.href ='install.php？lang ='+ this.value”>
                        <？php foreach（$ langs as $ key => $ val）：？>
                        <option value =“ <？php echo $ key;？>” <？php if（$ lang == $ key）：？> selected <？php endif; ？>> <？php echo $ val; ？> </ option>
                        <？php endforeach; ？>
                    </ select>
                    <？php endif; ？>
                </ p>
                </ form>
            <？php endif; ？>

            </ div>
        </ div>
    </ div>
</ div>
<？php
包括'admin / copyright.php';
包括'admin / footer.php';
？>
