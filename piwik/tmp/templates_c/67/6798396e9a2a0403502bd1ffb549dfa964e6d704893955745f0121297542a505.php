<?php

/* @UsersManager/userSettings.twig */
class __TwigTemplate_0d7dc445ebcf52423c76fcbc941abf633af52e7adefceee66312ea7aa9185dbb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("admin.twig", "@UsersManager/userSettings.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "admin.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 3
        ob_start();
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_PersonalSettings")), "html", null, true);
        $context["title"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "
<div class=\"ui-confirm\" id=\"confirmTokenRegenerate\">
    <h2>";
        // line 8
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_TokenRegenerateConfirmSelf")), "html", null, true);
        echo "</h2>
    <input role=\"yes\" type=\"button\" value=\"";
        // line 9
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Yes")), "html", null, true);
        echo "\"/>
    <input role=\"no\" type=\"button\" value=\"";
        // line 10
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_No")), "html", null, true);
        echo "\"/>
</div>

<div piwik-content-block content-title=\"";
        // line 13
        echo \Piwik\piwik_escape_filter($this->env, ($context["title"] ?? $this->getContext($context, "title")), "html_attr");
        echo "\" feature=\"true\">
    <form id=\"userSettingsTable\" piwik-form ng-controller=\"PersonalSettingsController as personalSettings\">

        <div piwik-field uicontrol=\"text\" name=\"username\"
             title=\"";
        // line 17
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Username")), "html_attr");
        echo "\"
             value=\"";
        // line 18
        echo \Piwik\piwik_escape_filter($this->env, ($context["userLogin"] ?? $this->getContext($context, "userLogin")), "html", null, true);
        echo "\" disabled=\"true\"
             ng-model=\"personalSettings.username\"
             inline-help=\"";
        // line 20
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_YourUsernameCannotBeChanged")), "html_attr");
        echo "\">
        </div>

        <div piwik-field uicontrol=\"text\" name=\"alias\"
             ng-model=\"personalSettings.alias\"
             maxlength=\"45\"
             title=\"";
        // line 26
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_Alias")), "html_attr");
        echo "\"
             value=\"";
        // line 27
        echo ($context["userAlias"] ?? $this->getContext($context, "userAlias"));
        echo "\">
        </div>

        <div piwik-field uicontrol=\"text\" name=\"email\"
             ng-model=\"personalSettings.email\"
             maxlength=\"100\"
             title=\"";
        // line 33
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_Email")), "html_attr");
        echo "\"
             value=\"";
        // line 34
        echo \Piwik\piwik_escape_filter($this->env, ($context["userEmail"] ?? $this->getContext($context, "userEmail")), "html", null, true);
        echo "\">
        </div>

        <div id=\"languageHelp\" class=\"inline-help-node\">
            <a href=\"?module=Proxy&amp;action=redirect&amp;url=https://matomo.org/translations/\" target=\"_blank\">
                ";
        // line 39
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("LanguagesManager_AboutPiwikTranslations")), "html", null, true);
        echo "</a>
        </div>

        <div piwik-field uicontrol=\"select\" name=\"language\"
             ng-model=\"personalSettings.language\"
             title=\"";
        // line 44
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Language")), "html_attr");
        echo "\"
             options=\"";
        // line 45
        echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["languageOptions"] ?? $this->getContext($context, "languageOptions"))), "html", null, true);
        echo "\"
             inline-help=\"#languageHelp\"
             value=\"";
        // line 47
        echo \Piwik\piwik_escape_filter($this->env, ($context["currentLanguageCode"] ?? $this->getContext($context, "currentLanguageCode")), "html", null, true);
        echo "\">
        </div>

        <div piwik-field uicontrol=\"select\" name=\"timeformat\"
             ng-model=\"personalSettings.timeformat\"
             title=\"";
        // line 52
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_TimeFormat")), "html_attr");
        echo "\"
             value=\"";
        // line 53
        echo \Piwik\piwik_escape_filter($this->env, ($context["currentTimeformat"] ?? $this->getContext($context, "currentTimeformat")), "html", null, true);
        echo "\" options=\"";
        echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["timeFormats"] ?? $this->getContext($context, "timeFormats"))), "html", null, true);
        echo "\">
        </div>

        <div piwik-field uicontrol=\"radio\" name=\"defaultReport\"
             ng-model=\"personalSettings.defaultReport\"
             introduction=\"";
        // line 58
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ReportToLoadByDefault")), "html_attr");
        echo "\"
             title=\"";
        // line 59
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_AllWebsitesDashboard")), "html_attr");
        echo "\"
             value=\"";
        // line 60
        echo \Piwik\piwik_escape_filter($this->env, ($context["defaultReport"] ?? $this->getContext($context, "defaultReport")), "html", null, true);
        echo "\" options=\"";
        echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["defaultReportOptions"] ?? $this->getContext($context, "defaultReportOptions"))), "html", null, true);
        echo "\">
        </div>

        <div piwik-siteselector
             ng-model=\"personalSettings.site\"
             show-selected-site=\"true\"
             class=\"sites_autocomplete\"
             siteid=\"";
        // line 67
        echo \Piwik\piwik_escape_filter($this->env, ($context["defaultReportIdSite"] ?? $this->getContext($context, "defaultReportIdSite")), "html", null, true);
        echo "\"
             sitename=\"";
        // line 68
        echo \Piwik\piwik_escape_filter($this->env, ($context["defaultReportSiteName"] ?? $this->getContext($context, "defaultReportSiteName")), "html", null, true);
        echo "\"
             switch-site-on-select=\"false\"
             show-all-sites-item=\"false\"
             showselectedsite=\"true\"
             id=\"defaultReportSiteSelector\"
        ></div>

        <div piwik-field uicontrol=\"radio\" name=\"defaultDate\"
             ng-model=\"personalSettings.defaultDate\"
             introduction=\"";
        // line 77
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ReportDateToLoadByDefault")), "html_attr");
        echo "\"
             value=\"";
        // line 78
        echo \Piwik\piwik_escape_filter($this->env, ($context["defaultDate"] ?? $this->getContext($context, "defaultDate")), "html", null, true);
        echo "\" options=\"";
        echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["availableDefaultDates"] ?? $this->getContext($context, "availableDefaultDates"))), "html", null, true);
        echo "\">
        </div>

        ";
        // line 81
        if ((array_key_exists("isValidHost", $context) && ($context["isValidHost"] ?? $this->getContext($context, "isValidHost")))) {
            // line 82
            echo "
            <div piwik-field uicontrol=\"password\" name=\"password\" autocomplete=\"off\"
                 ng-model=\"personalSettings.password\"
                 introduction=\"";
            // line 85
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_ChangePassword")), "html_attr");
            echo "\"
                 title=\"";
            // line 86
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_NewPassword")), "html_attr");
            echo "\"
                 value=\"\" inline-help=\"";
            // line 87
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_IfYouWouldLikeToChangeThePasswordTypeANewOne")), "html_attr");
            echo "\">
            </div>

            <div piwik-field uicontrol=\"password\" name=\"passwordBis\" autocomplete=\"off\"
                 ng-model=\"personalSettings.passwordBis\"
                 title=\"";
            // line 92
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Login_NewPasswordRepeat")), "html_attr");
            echo "\"
                 value=\"\" inline-help=\"";
            // line 93
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_TypeYourPasswordAgain")), "html_attr");
            echo "\">
            </div>
        ";
        }
        // line 96
        echo "
        ";
        // line 97
        if (( !array_key_exists("isValidHost", $context) ||  !($context["isValidHost"] ?? $this->getContext($context, "isValidHost")))) {
            // line 98
            echo "            <div class=\"alert alert-danger\">
                ";
            // line 99
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_InjectedHostCannotChangePwd", ($context["invalidHost"] ?? $this->getContext($context, "invalidHost")))), "html", null, true);
            echo "
                ";
            // line 100
            if ( !($context["isSuperUser"] ?? $this->getContext($context, "isSuperUser"))) {
                echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_EmailYourAdministrator", ($context["invalidHostMailLinkStart"] ?? $this->getContext($context, "invalidHostMailLinkStart")), "</a>"));
            }
            // line 101
            echo "            </div>
        ";
        }
        // line 103
        echo "
        <div piwik-save-button onconfirm=\"personalSettings.save()\"
             saving=\"personalSettings.loading\"></div>

    </form>
</div>

<div piwik-content-block
     content-title=\"";
        // line 111
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_TokenAuth")), "html_attr");
        echo "\">
    <pre piwik-select-on-focus id=\"token_auth_user\" piwik-show-sensitive-data=\"";
        // line 112
        echo \Piwik\piwik_escape_filter($this->env, ($context["userTokenAuth"] ?? $this->getContext($context, "userTokenAuth")), "html", null, true);
        echo "\"></pre>

    <p>";
        // line 114
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_TokenRegenerateLogoutWarning")), "html", null, true);
        echo "</p>
    <button class=\"btn btn-link\"
            ng-controller=\"PersonalSettingsController as personalSettings\"
            ng-click=\"personalSettings.regenerateTokenAuth()\">";
        // line 117
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_TokenRegenerateTitle")), "html", null, true);
        echo "</button>
</div>

<div piwik-plugin-settings mode=\"user\"></div>

<div piwik-content-block
     content-title=\"";
        // line 123
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ExcludeVisitsViaCookie")), "html_attr");
        echo "\">
    <p>
        ";
        // line 125
        if (($context["ignoreCookieSet"] ?? $this->getContext($context, "ignoreCookieSet"))) {
            // line 126
            echo "            ";
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_YourVisitsAreIgnoredOnDomain", "<strong>", ($context["piwikHost"] ?? $this->getContext($context, "piwikHost")), "</strong>"));
            echo "
        ";
        } else {
            // line 128
            echo "            ";
            echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_YourVisitsAreNotIgnored", "<strong>", "</strong>"));
            echo "
        ";
        }
        // line 130
        echo "    </p>
    <span style=\"margin-left:20px;\">
    <a href='";
        // line 132
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFunction('linkTo')->getCallable(), array(array("ignoreSalt" => ($context["ignoreSalt"] ?? $this->getContext($context, "ignoreSalt")), "module" => "UsersManager", "action" => "setIgnoreCookie"))), "html", null, true);
        echo "#excludeCookie'>&rsaquo; ";
        if (($context["ignoreCookieSet"] ?? $this->getContext($context, "ignoreCookieSet"))) {
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ClickHereToDeleteTheCookie")), "html", null, true);
            echo "
        ";
        } else {
            // line 133
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("UsersManager_ClickHereToSetTheCookieOnDomain", ($context["piwikHost"] ?? $this->getContext($context, "piwikHost")))), "html", null, true);
        }
        // line 134
        echo "        <br/>
    </a></span>
</div>

";
    }

    public function getTemplateName()
    {
        return "@UsersManager/userSettings.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  312 => 134,  309 => 133,  301 => 132,  297 => 130,  291 => 128,  285 => 126,  283 => 125,  278 => 123,  269 => 117,  263 => 114,  258 => 112,  254 => 111,  244 => 103,  240 => 101,  236 => 100,  232 => 99,  229 => 98,  227 => 97,  224 => 96,  218 => 93,  214 => 92,  206 => 87,  202 => 86,  198 => 85,  193 => 82,  191 => 81,  183 => 78,  179 => 77,  167 => 68,  163 => 67,  151 => 60,  147 => 59,  143 => 58,  133 => 53,  129 => 52,  121 => 47,  116 => 45,  112 => 44,  104 => 39,  96 => 34,  92 => 33,  83 => 27,  79 => 26,  70 => 20,  65 => 18,  61 => 17,  54 => 13,  48 => 10,  44 => 9,  40 => 8,  36 => 6,  33 => 5,  29 => 1,  25 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'admin.twig' %}

{% set title %}{{ 'UsersManager_PersonalSettings'|translate }}{% endset %}

{% block content %}

<div class=\"ui-confirm\" id=\"confirmTokenRegenerate\">
    <h2>{{ 'UsersManager_TokenRegenerateConfirmSelf'|translate }}</h2>
    <input role=\"yes\" type=\"button\" value=\"{{ 'General_Yes'|translate }}\"/>
    <input role=\"no\" type=\"button\" value=\"{{ 'General_No'|translate }}\"/>
</div>

<div piwik-content-block content-title=\"{{ title|e('html_attr') }}\" feature=\"true\">
    <form id=\"userSettingsTable\" piwik-form ng-controller=\"PersonalSettingsController as personalSettings\">

        <div piwik-field uicontrol=\"text\" name=\"username\"
             title=\"{{ 'General_Username'|translate|e('html_attr') }}\"
             value=\"{{ userLogin }}\" disabled=\"true\"
             ng-model=\"personalSettings.username\"
             inline-help=\"{{ 'UsersManager_YourUsernameCannotBeChanged'|translate|e('html_attr') }}\">
        </div>

        <div piwik-field uicontrol=\"text\" name=\"alias\"
             ng-model=\"personalSettings.alias\"
             maxlength=\"45\"
             title=\"{{ 'UsersManager_Alias'|translate|e('html_attr') }}\"
             value=\"{{ userAlias|raw }}\">
        </div>

        <div piwik-field uicontrol=\"text\" name=\"email\"
             ng-model=\"personalSettings.email\"
             maxlength=\"100\"
             title=\"{{ 'UsersManager_Email'|translate|e('html_attr') }}\"
             value=\"{{ userEmail }}\">
        </div>

        <div id=\"languageHelp\" class=\"inline-help-node\">
            <a href=\"?module=Proxy&amp;action=redirect&amp;url=https://matomo.org/translations/\" target=\"_blank\">
                {{ 'LanguagesManager_AboutPiwikTranslations'|translate }}</a>
        </div>

        <div piwik-field uicontrol=\"select\" name=\"language\"
             ng-model=\"personalSettings.language\"
             title=\"{{ 'General_Language'|translate|e('html_attr') }}\"
             options=\"{{ languageOptions|json_encode }}\"
             inline-help=\"#languageHelp\"
             value=\"{{ currentLanguageCode }}\">
        </div>

        <div piwik-field uicontrol=\"select\" name=\"timeformat\"
             ng-model=\"personalSettings.timeformat\"
             title=\"{{ 'General_TimeFormat'|translate|e('html_attr') }}\"
             value=\"{{ currentTimeformat }}\" options=\"{{ timeFormats|json_encode }}\">
        </div>

        <div piwik-field uicontrol=\"radio\" name=\"defaultReport\"
             ng-model=\"personalSettings.defaultReport\"
             introduction=\"{{ 'UsersManager_ReportToLoadByDefault'|translate|e('html_attr') }}\"
             title=\"{{ 'General_AllWebsitesDashboard'|translate|e('html_attr') }}\"
             value=\"{{ defaultReport }}\" options=\"{{ defaultReportOptions|json_encode }}\">
        </div>

        <div piwik-siteselector
             ng-model=\"personalSettings.site\"
             show-selected-site=\"true\"
             class=\"sites_autocomplete\"
             siteid=\"{{ defaultReportIdSite }}\"
             sitename=\"{{ defaultReportSiteName }}\"
             switch-site-on-select=\"false\"
             show-all-sites-item=\"false\"
             showselectedsite=\"true\"
             id=\"defaultReportSiteSelector\"
        ></div>

        <div piwik-field uicontrol=\"radio\" name=\"defaultDate\"
             ng-model=\"personalSettings.defaultDate\"
             introduction=\"{{ 'UsersManager_ReportDateToLoadByDefault'|translate|e('html_attr') }}\"
             value=\"{{ defaultDate }}\" options=\"{{ availableDefaultDates|json_encode }}\">
        </div>

        {% if isValidHost is defined and isValidHost %}

            <div piwik-field uicontrol=\"password\" name=\"password\" autocomplete=\"off\"
                 ng-model=\"personalSettings.password\"
                 introduction=\"{{ 'General_ChangePassword'|translate|e('html_attr') }}\"
                 title=\"{{ 'Login_NewPassword'|translate|e('html_attr') }}\"
                 value=\"\" inline-help=\"{{ 'UsersManager_IfYouWouldLikeToChangeThePasswordTypeANewOne'|translate|e('html_attr') }}\">
            </div>

            <div piwik-field uicontrol=\"password\" name=\"passwordBis\" autocomplete=\"off\"
                 ng-model=\"personalSettings.passwordBis\"
                 title=\"{{ 'Login_NewPasswordRepeat'|translate|e('html_attr') }}\"
                 value=\"\" inline-help=\"{{ 'UsersManager_TypeYourPasswordAgain'|translate|e('html_attr') }}\">
            </div>
        {% endif %}

        {% if isValidHost is not defined or not isValidHost %}
            <div class=\"alert alert-danger\">
                {{ 'UsersManager_InjectedHostCannotChangePwd'|translate(invalidHost) }}
                {% if not isSuperUser %}{{ 'UsersManager_EmailYourAdministrator'|translate(invalidHostMailLinkStart,'</a>')|raw }}{% endif %}
            </div>
        {% endif %}

        <div piwik-save-button onconfirm=\"personalSettings.save()\"
             saving=\"personalSettings.loading\"></div>

    </form>
</div>

<div piwik-content-block
     content-title=\"{{ 'UsersManager_TokenAuth'|translate|e('html_attr') }}\">
    <pre piwik-select-on-focus id=\"token_auth_user\" piwik-show-sensitive-data=\"{{ userTokenAuth }}\"></pre>

    <p>{{ 'UsersManager_TokenRegenerateLogoutWarning'|translate }}</p>
    <button class=\"btn btn-link\"
            ng-controller=\"PersonalSettingsController as personalSettings\"
            ng-click=\"personalSettings.regenerateTokenAuth()\">{{ 'UsersManager_TokenRegenerateTitle'|translate }}</button>
</div>

<div piwik-plugin-settings mode=\"user\"></div>

<div piwik-content-block
     content-title=\"{{ 'UsersManager_ExcludeVisitsViaCookie'|translate|e('html_attr') }}\">
    <p>
        {% if ignoreCookieSet %}
            {{ 'UsersManager_YourVisitsAreIgnoredOnDomain'|translate(\"<strong>\", piwikHost, \"</strong>\")|raw }}
        {% else %}
            {{ 'UsersManager_YourVisitsAreNotIgnored'|translate(\"<strong>\",\"</strong>\")|raw }}
        {% endif %}
    </p>
    <span style=\"margin-left:20px;\">
    <a href='{{ linkTo({'ignoreSalt':ignoreSalt, 'module': 'UsersManager', 'action':'setIgnoreCookie'}) }}#excludeCookie'>&rsaquo; {% if ignoreCookieSet %}{{ 'UsersManager_ClickHereToDeleteTheCookie'|translate }}
        {% else %}{{'UsersManager_ClickHereToSetTheCookieOnDomain'|translate(piwikHost) }}{% endif %}
        <br/>
    </a></span>
</div>

{% endblock %}
", "@UsersManager/userSettings.twig", "/srv/www/piwik/plugins/UsersManager/templates/userSettings.twig");
    }
}
