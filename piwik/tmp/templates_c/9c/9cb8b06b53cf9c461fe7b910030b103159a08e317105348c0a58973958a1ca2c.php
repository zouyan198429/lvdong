<?php

/* @CoreAdminHome/trackingCodeGenerator.twig */
class __TwigTemplate_1461aa3c7cb09163220460ac5491f8c2be2150a51e32ae7f07610a98b1c84000 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("admin.twig", "@CoreAdminHome/trackingCodeGenerator.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "admin.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 8
        ob_start();
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_TrackingCode")), "html", null, true);
        $context["title"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "
    <link rel=\"stylesheet\" href=\"plugins/CoreAdminHome/stylesheets/jsTrackingGenerator.css\" />
";
    }

    // line 10
    public function block_content($context, array $blocks = array())
    {
        // line 11
        echo "
    <div class=\"card\">
        <div class=\"card-content\">
            <h2 piwik-enriched-headline
                help-url=\"https://matomo.org/docs/tracking-api/\"
                rate=\"";
        // line 16
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_TrackingCode")), "html_attr");
        echo "\">";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_TrackingCode")), "html", null, true);
        echo "</h2>
            <p style=\"padding-left: 0;\">";
        // line 17
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_TrackingCodeIntro")), "html", null, true);
        echo "</p>
        </div>
        <div class=\"card-action\">
            ";
        // line 20
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_GoTo2")), "html", null, true);
        echo ":
            <a href=\"#javaScriptTracking\">";
        // line 21
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JavaScriptTracking")), "html", null, true);
        echo "</a>
            <a href=\"#imageTracking\">";
        // line 22
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTracking")), "html", null, true);
        echo "</a>
            <a href=\"#importServerLogs\">";
        // line 23
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImportingServerLogs")), "html", null, true);
        echo "</a>
            <a href=\"#mobileAppsAndSdks\">";
        // line 24
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_MobileAppsAndSDKs")), "html", null, true);
        echo "</a>
            <a href=\"#trackingApi\">";
        // line 25
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_HttpTrackingApi")), "html", null, true);
        echo "</a>
            ";
        // line 26
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.endTrackingCodePageTableOfContents"));
        echo "
        </div>
    </div>

    <input type=\"hidden\" name=\"numMaxCustomVariables\"
           value=\"";
        // line 31
        echo \Piwik\piwik_escape_filter($this->env, ($context["maxCustomVariables"] ?? $this->getContext($context, "maxCustomVariables")), "html_attr");
        echo "\">

<div piwik-content-block
     anchor=\"javaScriptTracking\"
     content-title=\"";
        // line 35
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JavaScriptTracking")), "html_attr");
        echo "\">

    <div id=\"js-code-options\" ng-controller=\"JsTrackingCodeController as jsTrackingCode\">

        <p>
            ";
        // line 40
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTrackingIntro1")), "html", null, true);
        echo "
            <br/><br/>
            ";
        // line 42
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTrackingIntro2")), "html", null, true);
        echo " ";
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTrackingIntro3b", "<a href=\"https://matomo.org/integrate/\" rel=\"noreferrer noopener\" target=\"_blank\">", "</a>"));
        echo "
            <br/><br/>
            ";
        // line 44
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTrackingIntro4", "<a href=\"#image-tracking-link\">", "</a>"));
        echo "
            <br/><br/>
            ";
        // line 46
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTrackingIntro5", "<a rel=\"noreferrer noopener\" target=\"_blank\" href=\"https://matomo.org/docs/javascript-tracking/\">", "</a>"));
        echo "
        </p>

        <div piwik-field uicontrol=\"site\" name=\"js-tracker-website\"
             class=\"jsTrackingCodeWebsite\"
             ng-model=\"jsTrackingCode.site\"
             ng-change=\"jsTrackingCode.changeSite(true)\"
             introduction=\"";
        // line 53
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Website")), "html_attr");
        echo "\"
             value='";
        // line 54
        echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["defaultSite"] ?? $this->getContext($context, "defaultSite"))), "html", null, true);
        echo "'>
        </div>

        <div id=\"optional-js-tracking-options\">

            ";
        // line 60
        echo "            <div id=\"jsTrackAllSubdomainsInlineHelp\" class=\"inline-help-node\">
                ";
        // line 61
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_MergeSubdomainsDesc", "x.<span class='current-site-host'></span>", "y.<span class='current-site-host'></span>"));
        echo "
                ";
        // line 62
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_LearnMore", " (<a href=\"https://developer.matomo.org/guides/tracking-javascript-guide#measuring-domains-andor-sub-domains\" rel=\"noreferrer noopener\" target=\"_blank\">", "</a>)"));
        echo "
            </div>

            <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-all-subdomains\"
                 ng-model=\"jsTrackingCode.trackAllSubdomains\"
                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                 disabled=\"jsTrackingCode.isLoading\"
                 introduction=\"";
        // line 69
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Options")), "html_attr");
        echo "\"
                 title=\"";
        // line 70
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_MergeSubdomains")), "html_attr");
        echo " <span class='current-site-name'></span>\"
                 value=\"\" inline-help=\"#jsTrackAllSubdomainsInlineHelp\">
            </div>

            ";
        // line 75
        echo "            <div id=\"jsTrackGroupByDomainInlineHelp\" class=\"inline-help-node\">
                ";
        // line 76
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_GroupPageTitlesByDomainDesc1", "<span class='current-site-host'></span>"));
        echo "
            </div>

            <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-group-by-domain\"
                 ng-model=\"jsTrackingCode.groupByDomain\"
                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                 disabled=\"jsTrackingCode.isLoading\"
                 title=\"";
        // line 83
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_GroupPageTitlesByDomain")), "html_attr");
        echo "\"
                 value=\"\" inline-help=\"#jsTrackGroupByDomainInlineHelp\">
            </div>

            ";
        // line 88
        echo "            <div id=\"jsTrackAllAliasesInlineHelp\" class=\"inline-help-node\">
                ";
        // line 89
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_MergeAliasesDesc", "<span class='current-site-alias'></span>"));
        echo "
            </div>

            <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-all-aliases\"
                 ng-model=\"jsTrackingCode.trackAllAliases\"
                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                 disabled=\"jsTrackingCode.isLoading\"
                 title=\"";
        // line 96
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_MergeAliases")), "html_attr");
        echo " <span class='current-site-name'></span>\"
                 value=\"\" inline-help=\"#jsTrackAllAliasesInlineHelp\">
            </div>

            <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-noscript\"
                 ng-model=\"jsTrackingCode.trackNoScript\"
                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                 disabled=\"jsTrackingCode.isLoading\"
                 title=\"";
        // line 104
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_TrackNoScript")), "html_attr");
        echo "\"
                 value=\"\" inline-help=\"\">
            </div>

            <h3>";
        // line 108
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Mobile_Advanced")), "html", null, true);
        echo "</h3>

            <p>
                <a href=\"javascript:;\"
                   ng-show=\"!jsTrackingCode.showAdvanced\"
                   ng-click=\"jsTrackingCode.showAdvanced = true\">";
        // line 113
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Show")), "html", null, true);
        echo "</a>
                <a href=\"javascript:;\"
                   ng-show=\"jsTrackingCode.showAdvanced\"
                   ng-click=\"jsTrackingCode.showAdvanced = false\">";
        // line 116
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Hide")), "html", null, true);
        echo "</a>
            </p>

            <div id=\"javascript-advanced-options\" ng-show=\"jsTrackingCode.showAdvanced\">

                ";
        // line 122
        echo "                <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-visitor-cv-check\"
                     ng-model=\"jsTrackingCode.trackCustomVars\"
                     ng-change=\"jsTrackingCode.updateTrackingCode()\"
                     disabled=\"jsTrackingCode.isLoading\"
                     title=\"";
        // line 126
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_VisitorCustomVars")), "html_attr");
        echo "\"
                     value=\"\" inline-help=\"";
        // line 127
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_VisitorCustomVarsDesc")), "html_attr");
        echo "\">
                </div>

                <div id=\"javascript-tracking-visitor-cv\" ng-show=\"jsTrackingCode.trackCustomVars\">
                    <div class=\"row\">
                        <div class=\"col s12 m3\">
                            ";
        // line 133
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Name")), "html", null, true);
        echo "
                        </div>
                        <div class=\"col s12 m3\">
                            ";
        // line 136
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Value")), "html", null, true);
        echo "
                        </div>
                    </div>
                    <div class=\"row\" ng-repeat=\"customVar in jsTrackingCode.customVars\">
                        <div class=\"col s12 m6 l3\">
                            <input type=\"text\" class=\"custom-variable-name\"
                                   ng-change=\"jsTrackingCode.updateTrackingCode()\"
                                   ng-model=\"jsTrackingCode.customVars[\$index.toString()].name\"
                                   placeholder=\"e.g. Type\"/>
                        </div>
                        <div class=\"col s12 m6 l3\">
                            <input type=\"text\" class=\"custom-variable-value\"
                                   ng-change=\"jsTrackingCode.updateTrackingCode()\"
                                   ng-model=\"jsTrackingCode.customVars[\$index.toString()].value\"
                                   placeholder=\"e.g. Customer\"/>
                        </div>
                    </div>
                    <div class=\"row\" ng-show=\"jsTrackingCode.canAddMoreCustomVariables\">
                        <div class=\"col s12\">
                            <a href=\"javascript:;\"
                               ng-click=\"jsTrackingCode.addCustomVar()\"
                               class=\"add-custom-variable\"><span class=\"icon-add\"></span> ";
        // line 157
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Add")), "html", null, true);
        echo "</a>
                        </div>
                    </div>
                </div>

                ";
        // line 163
        echo "                <div id=\"jsCrossDomain\" class=\"inline-help-node\">
                    ";
        // line 164
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CrossDomain")), "html", null, true);
        echo "
                    <br/>
                    ";
        // line 166
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CrossDomain_NeedsMultipleDomains")), "html", null, true);
        echo "
                </div>

                <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-cross-domain\"
                     ng-model=\"jsTrackingCode.crossDomain\"
                     ng-change=\"jsTrackingCode.updateTrackingCode();jsTrackingCode.onCrossDomainToggle();\"
                     disabled=\"jsTrackingCode.isLoading || !jsTrackingCode.hasManySiteUrls\"
                     title=\"";
        // line 173
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_EnableCrossDomainLinking")), "html_attr");
        echo "\"
                     value=\"\" inline-help=\"#jsCrossDomain\">
                </div>

                ";
        // line 178
        echo "                <div id=\"jsDoNotTrackInlineHelp\" class=\"inline-help-node\">
                    ";
        // line 179
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_EnableDoNotTrackDesc")), "html", null, true);
        echo "
                    ";
        // line 180
        if (($context["serverSideDoNotTrackEnabled"] ?? $this->getContext($context, "serverSideDoNotTrackEnabled"))) {
            // line 181
            echo "                        <br/>
                        ";
            // line 182
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_EnableDoNotTrack_AlreadyEnabled")), "html", null, true);
            echo "
                    ";
        }
        // line 184
        echo "                </div>

                <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-do-not-track\"
                     ng-model=\"jsTrackingCode.doNotTrack\"
                     ng-change=\"jsTrackingCode.updateTrackingCode() \"
                     disabled=\"jsTrackingCode.isLoading\"
                     title=\"";
        // line 190
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_EnableDoNotTrack")), "html_attr");
        echo "\"
                     value=\"\" inline-help=\"#jsDoNotTrackInlineHelp\">
                </div>

                ";
        // line 195
        echo "                <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-disable-cookies\"
                     ng-model=\"jsTrackingCode.disableCookies\"
                     disabled=\"jsTrackingCode.isLoading\"
                     ng-change=\"jsTrackingCode.updateTrackingCode()\"
                     title=\"";
        // line 199
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_DisableCookies")), "html_attr");
        echo "\"
                     value=\"\" inline-help=\"";
        // line 200
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_DisableCookiesDesc")), "html_attr");
        echo "\">
                </div>

                ";
        // line 204
        echo "                <div id=\"jsTrackCampaignParamsInlineHelp\" class=\"inline-help-node\">
                    ";
        // line 205
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CustomCampaignQueryParamDesc", "<a href=\"https://matomo.org/faq/general/#faq_119\" rel=\"noreferrer noopener\" target=\"_blank\">", "</a>"));
        echo "
                </div>

                <div piwik-field uicontrol=\"checkbox\" name=\"custom-campaign-query-params-check\"
                     ng-model=\"jsTrackingCode.useCustomCampaignParams\"
                     disabled=\"jsTrackingCode.isLoading\"
                     ng-change=\"jsTrackingCode.updateTrackingCode()\"
                     title=\"";
        // line 212
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CustomCampaignQueryParam")), "html_attr");
        echo "\"
                     value=\"\" inline-help=\"#jsTrackCampaignParamsInlineHelp\">
                </div>

                <div ng-show=\"jsTrackingCode.useCustomCampaignParams\" id=\"js-campaign-query-param-extra\">
                    <div class=\"row\">
                        <div class=\"col s12\">
                            <div piwik-field uicontrol=\"text\" name=\"custom-campaign-name-query-param\"
                                 ng-model=\"jsTrackingCode.customCampaignName\"
                                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                                 disabled=\"jsTrackingCode.isLoading\"
                                 title=\"";
        // line 223
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CampaignNameParam")), "html_attr");
        echo "\"
                                 value=\"\">
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col s12\">
                            <div piwik-field uicontrol=\"text\" name=\"custom-campaign-keyword-query-param\"
                                 ng-model=\"jsTrackingCode.customCampaignKeyword\"
                                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                                 disabled=\"jsTrackingCode.isLoading\"
                                 title=\"";
        // line 234
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CampaignKwdParam")), "html_attr");
        echo "\"
                                 value=\"\">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div id=\"javascript-output-section\">
            <h3>";
        // line 246
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_JsTrackingTag")), "html", null, true);
        echo "</h3>

            <p>";
        // line 248
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_JSTracking_CodeNoteBeforeClosingHead", "&lt;/head&gt;"));
        echo "</p>

            <div id=\"javascript-text\">
                <pre piwik-select-on-focus class=\"codeblock\"
                     ng-bind=\"jsTrackingCode.trackingCode\"> </pre>
            </div>
        </div>
    </div>
</div>

<div piwik-content-block content-title=\"";
        // line 258
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTracking")), "html_attr");
        echo "\"
     anchor=\"imageTracking\">
    <a name=\"image-tracking-link\"></a>

    <div id=\"image-tracking-code-options\" ng-controller=\"ImageTrackingCodeController as imageTrackingCode\">

        <p>
            ";
        // line 265
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTrackingIntro1")), "html", null, true);
        echo " ";
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTrackingIntro2", "<code>&lt;noscript&gt;&lt;/noscript&gt;</code>"));
        echo "
        </p>
        <p>
            ";
        // line 268
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTrackingIntro3", "<a href=\"https://matomo.org/docs/tracking-api/reference/\" rel=\"noreferrer noopener\" target=\"_blank\">", "</a>"));
        echo "
        </p>

        ";
        // line 272
        echo "        <div piwik-field uicontrol=\"site\" name=\"image-tracker-website\"
             ng-model=\"imageTrackingCode.site\"
             ng-change=\"imageTrackingCode.changeSite(true)\"
             introduction=\"";
        // line 275
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Website")), "html_attr");
        echo "\"
             value='";
        // line 276
        echo \Piwik\piwik_escape_filter($this->env, twig_jsonencode_filter(($context["defaultSite"] ?? $this->getContext($context, "defaultSite"))), "html", null, true);
        echo "'>
        </div>

        ";
        // line 280
        echo "        <div piwik-field uicontrol=\"text\" name=\"image-tracker-action-name\"
             ng-model=\"imageTrackingCode.pageName\"
             ng-change=\"imageTrackingCode.updateTrackingCode()\"
             disabled=\"imageTrackingCode.isLoading\"
             introduction=\"";
        // line 284
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Options")), "html_attr");
        echo "\"
             title=\"";
        // line 285
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Actions_ColumnPageName")), "html_attr");
        echo "\"
             value=\"\">
        </div>

        ";
        // line 290
        echo "        <div piwik-field uicontrol=\"checkbox\" name=\"image-tracking-goal-check\"
             ng-model=\"imageTrackingCode.trackGoal\"
             ng-change=\"imageTrackingCode.updateTrackingCode()\"
             disabled=\"imageTrackingCode.isLoading\"
             title=\"";
        // line 294
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_TrackAGoal")), "html_attr");
        echo "\"
             value=\"\">
        </div>

        <div ng-show=\"imageTrackingCode.trackGoal\"
             id=\"image-tracking-goal-sub\">
            <div class=\"row\">
                <div class=\"col s12 m6\">
                    <div piwik-field uicontrol=\"select\" name=\"image-tracker-goal\"
                         options=\"imageTrackingCode.allGoals\"
                         disabled=\"imageTrackingCode.isLoading\"
                         ng-model=\"imageTrackingCode.trackIdGoal\"
                         full-width=\"true\"
                         ng-change=\"imageTrackingCode.updateTrackingCode()\"
                         value=\"\">
                    </div>
                </div>
                <div class=\"col s12 m6\">
                    <div piwik-field uicontrol=\"text\" name=\"image-revenue\"
                         ng-model=\"imageTrackingCode.revenue\"
                         ng-change=\"imageTrackingCode.updateTrackingCode()\"
                         disabled=\"imageTrackingCode.isLoading\"
                         full-width=\"true\"
                         title=\"";
        // line 317
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_WithOptionalRevenue")), "html_attr");
        echo " <span class='site-currency'></span>\"
                         value=\"\">
                    </div>
                </div>
            </div>
        </div>

        <div id=\"image-link-output-section\">
            <h3>";
        // line 325
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImageTrackingLink")), "html", null, true);
        echo "</h3>

            <div id=\"image-tracking-text\">
                <pre piwik-select-on-focus
                          ng-bind=\"imageTrackingCode.trackingCode\"> </pre>
            </div>
        </div>
    </div>
</div>

<div piwik-content-block content-title=\"";
        // line 335
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImportingServerLogs")), "html_attr");
        echo "\"
     anchor=\"importServerLogs\">
    <p>
        ";
        // line 338
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_ImportingServerLogsDesc", "<a href=\"https://matomo.org/log-analytics/\" rel=\"noreferrer noopener\" target=\"_blank\">", "</a>"));
        echo "
    </p>
</div>

<div piwik-content-block content-title=\"";
        // line 342
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_MobileAppsAndSDKs")), "html", null, true);
        echo "\" anchor=\"mobileAppsAndSdks\">
    <p>";
        // line 343
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_MobileAppsAndSDKsDescription", "<a href=\"https://matomo.org/integrate/#programming-language-platforms-and-frameworks\" rel=\"noreferrer noopener\" target=\"_blank\">", "</a>"));
        echo "</p>
</div>

<div piwik-content-block content-title=\"";
        // line 346
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_HttpTrackingApi")), "html", null, true);
        echo "\" anchor=\"trackingApi\">
    <p>";
        // line 347
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreAdminHome_HttpTrackingApiDescription", "<a href=\"https://developer.matomo.org/api-reference/tracking-api\" rel=\"noreferrer noopener\" target=\"_blank\">", "</a>"));
        echo "</p>
</div>

";
        // line 350
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.endTrackingCodePage"));
        echo "

";
    }

    public function getTemplateName()
    {
        return "@CoreAdminHome/trackingCodeGenerator.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  603 => 350,  597 => 347,  593 => 346,  587 => 343,  583 => 342,  576 => 338,  570 => 335,  557 => 325,  546 => 317,  520 => 294,  514 => 290,  507 => 285,  503 => 284,  497 => 280,  491 => 276,  487 => 275,  482 => 272,  476 => 268,  468 => 265,  458 => 258,  445 => 248,  440 => 246,  425 => 234,  411 => 223,  397 => 212,  387 => 205,  384 => 204,  378 => 200,  374 => 199,  368 => 195,  361 => 190,  353 => 184,  348 => 182,  345 => 181,  343 => 180,  339 => 179,  336 => 178,  329 => 173,  319 => 166,  314 => 164,  311 => 163,  303 => 157,  279 => 136,  273 => 133,  264 => 127,  260 => 126,  254 => 122,  246 => 116,  240 => 113,  232 => 108,  225 => 104,  214 => 96,  204 => 89,  201 => 88,  194 => 83,  184 => 76,  181 => 75,  174 => 70,  170 => 69,  160 => 62,  156 => 61,  153 => 60,  145 => 54,  141 => 53,  131 => 46,  126 => 44,  119 => 42,  114 => 40,  106 => 35,  99 => 31,  91 => 26,  87 => 25,  83 => 24,  79 => 23,  75 => 22,  71 => 21,  67 => 20,  61 => 17,  55 => 16,  48 => 11,  45 => 10,  37 => 4,  34 => 3,  30 => 1,  26 => 8,  11 => 1,);
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

{% block head %}
    {{ parent() }}
    <link rel=\"stylesheet\" href=\"plugins/CoreAdminHome/stylesheets/jsTrackingGenerator.css\" />
{% endblock %}

{% set title %}{{ 'CoreAdminHome_TrackingCode'|translate }}{% endset %}

{% block content %}

    <div class=\"card\">
        <div class=\"card-content\">
            <h2 piwik-enriched-headline
                help-url=\"https://matomo.org/docs/tracking-api/\"
                rate=\"{{ 'CoreAdminHome_TrackingCode'|translate|e('html_attr') }}\">{{ 'CoreAdminHome_TrackingCode'|translate  }}</h2>
            <p style=\"padding-left: 0;\">{{ 'CoreAdminHome_TrackingCodeIntro'|translate }}</p>
        </div>
        <div class=\"card-action\">
            {{ 'General_GoTo2'|translate }}:
            <a href=\"#javaScriptTracking\">{{ 'CoreAdminHome_JavaScriptTracking'|translate  }}</a>
            <a href=\"#imageTracking\">{{ 'CoreAdminHome_ImageTracking'|translate }}</a>
            <a href=\"#importServerLogs\">{{ 'CoreAdminHome_ImportingServerLogs'|translate }}</a>
            <a href=\"#mobileAppsAndSdks\">{{ 'SitesManager_MobileAppsAndSDKs'|translate }}</a>
            <a href=\"#trackingApi\">{{ 'CoreAdminHome_HttpTrackingApi'|translate }}</a>
            {{ postEvent('Template.endTrackingCodePageTableOfContents') }}
        </div>
    </div>

    <input type=\"hidden\" name=\"numMaxCustomVariables\"
           value=\"{{ maxCustomVariables|e('html_attr') }}\">

<div piwik-content-block
     anchor=\"javaScriptTracking\"
     content-title=\"{{ 'CoreAdminHome_JavaScriptTracking'|translate|e('html_attr') }}\">

    <div id=\"js-code-options\" ng-controller=\"JsTrackingCodeController as jsTrackingCode\">

        <p>
            {{ 'CoreAdminHome_JSTrackingIntro1'|translate }}
            <br/><br/>
            {{ 'CoreAdminHome_JSTrackingIntro2'|translate }} {{ 'CoreAdminHome_JSTrackingIntro3b'|translate('<a href=\"https://matomo.org/integrate/\" rel=\"noreferrer noopener\" target=\"_blank\">','</a>')|raw }}
            <br/><br/>
            {{ 'CoreAdminHome_JSTrackingIntro4'|translate('<a href=\"#image-tracking-link\">','</a>')|raw }}
            <br/><br/>
            {{ 'CoreAdminHome_JSTrackingIntro5'|translate('<a rel=\"noreferrer noopener\" target=\"_blank\" href=\"https://matomo.org/docs/javascript-tracking/\">','</a>')|raw }}
        </p>

        <div piwik-field uicontrol=\"site\" name=\"js-tracker-website\"
             class=\"jsTrackingCodeWebsite\"
             ng-model=\"jsTrackingCode.site\"
             ng-change=\"jsTrackingCode.changeSite(true)\"
             introduction=\"{{ 'General_Website'|translate|e('html_attr') }}\"
             value='{{ defaultSite|json_encode }}'>
        </div>

        <div id=\"optional-js-tracking-options\">

            {# track across all subdomains #}
            <div id=\"jsTrackAllSubdomainsInlineHelp\" class=\"inline-help-node\">
                {{ 'CoreAdminHome_JSTracking_MergeSubdomainsDesc'|translate(\"x.<span class='current-site-host'></span>\",\"y.<span class='current-site-host'></span>\")|raw }}
                {{ 'General_LearnMore'|translate(' (<a href=\"https://developer.matomo.org/guides/tracking-javascript-guide#measuring-domains-andor-sub-domains\" rel=\"noreferrer noopener\" target=\"_blank\">', '</a>)')|raw }}
            </div>

            <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-all-subdomains\"
                 ng-model=\"jsTrackingCode.trackAllSubdomains\"
                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                 disabled=\"jsTrackingCode.isLoading\"
                 introduction=\"{{ 'General_Options'|translate|e('html_attr') }}\"
                 title=\"{{ 'CoreAdminHome_JSTracking_MergeSubdomains'|translate|e('html_attr') }} <span class='current-site-name'></span>\"
                 value=\"\" inline-help=\"#jsTrackAllSubdomainsInlineHelp\">
            </div>

            {# group page titles by site domain #}
            <div id=\"jsTrackGroupByDomainInlineHelp\" class=\"inline-help-node\">
                {{ 'CoreAdminHome_JSTracking_GroupPageTitlesByDomainDesc1'|translate(\"<span class='current-site-host'></span>\")|raw }}
            </div>

            <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-group-by-domain\"
                 ng-model=\"jsTrackingCode.groupByDomain\"
                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                 disabled=\"jsTrackingCode.isLoading\"
                 title=\"{{ 'CoreAdminHome_JSTracking_GroupPageTitlesByDomain'|translate|e('html_attr') }}\"
                 value=\"\" inline-help=\"#jsTrackGroupByDomainInlineHelp\">
            </div>

            {# track across all site aliases #}
            <div id=\"jsTrackAllAliasesInlineHelp\" class=\"inline-help-node\">
                {{ 'CoreAdminHome_JSTracking_MergeAliasesDesc'|translate(\"<span class='current-site-alias'></span>\")|raw }}
            </div>

            <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-all-aliases\"
                 ng-model=\"jsTrackingCode.trackAllAliases\"
                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                 disabled=\"jsTrackingCode.isLoading\"
                 title=\"{{ 'CoreAdminHome_JSTracking_MergeAliases'|translate|e('html_attr') }} <span class='current-site-name'></span>\"
                 value=\"\" inline-help=\"#jsTrackAllAliasesInlineHelp\">
            </div>

            <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-noscript\"
                 ng-model=\"jsTrackingCode.trackNoScript\"
                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                 disabled=\"jsTrackingCode.isLoading\"
                 title=\"{{ 'CoreAdminHome_JSTracking_TrackNoScript'|translate|e('html_attr') }}\"
                 value=\"\" inline-help=\"\">
            </div>

            <h3>{{ 'Mobile_Advanced'|translate }}</h3>

            <p>
                <a href=\"javascript:;\"
                   ng-show=\"!jsTrackingCode.showAdvanced\"
                   ng-click=\"jsTrackingCode.showAdvanced = true\">{{ 'General_Show'|translate }}</a>
                <a href=\"javascript:;\"
                   ng-show=\"jsTrackingCode.showAdvanced\"
                   ng-click=\"jsTrackingCode.showAdvanced = false\">{{ 'General_Hide'|translate }}</a>
            </p>

            <div id=\"javascript-advanced-options\" ng-show=\"jsTrackingCode.showAdvanced\">

                {# visitor custom variable #}
                <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-visitor-cv-check\"
                     ng-model=\"jsTrackingCode.trackCustomVars\"
                     ng-change=\"jsTrackingCode.updateTrackingCode()\"
                     disabled=\"jsTrackingCode.isLoading\"
                     title=\"{{ 'CoreAdminHome_JSTracking_VisitorCustomVars'|translate|e('html_attr') }}\"
                     value=\"\" inline-help=\"{{ 'CoreAdminHome_JSTracking_VisitorCustomVarsDesc'|translate|e('html_attr') }}\">
                </div>

                <div id=\"javascript-tracking-visitor-cv\" ng-show=\"jsTrackingCode.trackCustomVars\">
                    <div class=\"row\">
                        <div class=\"col s12 m3\">
                            {{ 'General_Name'|translate }}
                        </div>
                        <div class=\"col s12 m3\">
                            {{ 'General_Value'|translate }}
                        </div>
                    </div>
                    <div class=\"row\" ng-repeat=\"customVar in jsTrackingCode.customVars\">
                        <div class=\"col s12 m6 l3\">
                            <input type=\"text\" class=\"custom-variable-name\"
                                   ng-change=\"jsTrackingCode.updateTrackingCode()\"
                                   ng-model=\"jsTrackingCode.customVars[\$index.toString()].name\"
                                   placeholder=\"e.g. Type\"/>
                        </div>
                        <div class=\"col s12 m6 l3\">
                            <input type=\"text\" class=\"custom-variable-value\"
                                   ng-change=\"jsTrackingCode.updateTrackingCode()\"
                                   ng-model=\"jsTrackingCode.customVars[\$index.toString()].value\"
                                   placeholder=\"e.g. Customer\"/>
                        </div>
                    </div>
                    <div class=\"row\" ng-show=\"jsTrackingCode.canAddMoreCustomVariables\">
                        <div class=\"col s12\">
                            <a href=\"javascript:;\"
                               ng-click=\"jsTrackingCode.addCustomVar()\"
                               class=\"add-custom-variable\"><span class=\"icon-add\"></span> {{ 'General_Add'|translate }}</a>
                        </div>
                    </div>
                </div>

                {# cross domain support #}
                <div id=\"jsCrossDomain\" class=\"inline-help-node\">
                    {{ \"CoreAdminHome_JSTracking_CrossDomain\"|translate }}
                    <br/>
                    {{ 'CoreAdminHome_JSTracking_CrossDomain_NeedsMultipleDomains'|translate }}
                </div>

                <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-cross-domain\"
                     ng-model=\"jsTrackingCode.crossDomain\"
                     ng-change=\"jsTrackingCode.updateTrackingCode();jsTrackingCode.onCrossDomainToggle();\"
                     disabled=\"jsTrackingCode.isLoading || !jsTrackingCode.hasManySiteUrls\"
                     title=\"{{ 'CoreAdminHome_JSTracking_EnableCrossDomainLinking'|translate|e('html_attr') }}\"
                     value=\"\" inline-help=\"#jsCrossDomain\">
                </div>

                {# do not track support #}
                <div id=\"jsDoNotTrackInlineHelp\" class=\"inline-help-node\">
                    {{ 'CoreAdminHome_JSTracking_EnableDoNotTrackDesc'|translate }}
                    {% if serverSideDoNotTrackEnabled %}
                        <br/>
                        {{ 'CoreAdminHome_JSTracking_EnableDoNotTrack_AlreadyEnabled'|translate }}
                    {% endif %}
                </div>

                <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-do-not-track\"
                     ng-model=\"jsTrackingCode.doNotTrack\"
                     ng-change=\"jsTrackingCode.updateTrackingCode() \"
                     disabled=\"jsTrackingCode.isLoading\"
                     title=\"{{ 'CoreAdminHome_JSTracking_EnableDoNotTrack'|translate|e('html_attr') }}\"
                     value=\"\" inline-help=\"#jsDoNotTrackInlineHelp\">
                </div>

                {# disable all cookies options #}
                <div piwik-field uicontrol=\"checkbox\" name=\"javascript-tracking-disable-cookies\"
                     ng-model=\"jsTrackingCode.disableCookies\"
                     disabled=\"jsTrackingCode.isLoading\"
                     ng-change=\"jsTrackingCode.updateTrackingCode()\"
                     title=\"{{ 'CoreAdminHome_JSTracking_DisableCookies'|translate|e('html_attr') }}\"
                     value=\"\" inline-help=\"{{ 'CoreAdminHome_JSTracking_DisableCookiesDesc'|translate|e('html_attr') }}\">
                </div>

                {# custom campaign name/keyword query params #}
                <div id=\"jsTrackCampaignParamsInlineHelp\" class=\"inline-help-node\">
                    {{ 'CoreAdminHome_JSTracking_CustomCampaignQueryParamDesc'|translate('<a href=\"https://matomo.org/faq/general/#faq_119\" rel=\"noreferrer noopener\" target=\"_blank\">','</a>')|raw }}
                </div>

                <div piwik-field uicontrol=\"checkbox\" name=\"custom-campaign-query-params-check\"
                     ng-model=\"jsTrackingCode.useCustomCampaignParams\"
                     disabled=\"jsTrackingCode.isLoading\"
                     ng-change=\"jsTrackingCode.updateTrackingCode()\"
                     title=\"{{ 'CoreAdminHome_JSTracking_CustomCampaignQueryParam'|translate|e('html_attr') }}\"
                     value=\"\" inline-help=\"#jsTrackCampaignParamsInlineHelp\">
                </div>

                <div ng-show=\"jsTrackingCode.useCustomCampaignParams\" id=\"js-campaign-query-param-extra\">
                    <div class=\"row\">
                        <div class=\"col s12\">
                            <div piwik-field uicontrol=\"text\" name=\"custom-campaign-name-query-param\"
                                 ng-model=\"jsTrackingCode.customCampaignName\"
                                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                                 disabled=\"jsTrackingCode.isLoading\"
                                 title=\"{{ 'CoreAdminHome_JSTracking_CampaignNameParam'|translate|e('html_attr') }}\"
                                 value=\"\">
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col s12\">
                            <div piwik-field uicontrol=\"text\" name=\"custom-campaign-keyword-query-param\"
                                 ng-model=\"jsTrackingCode.customCampaignKeyword\"
                                 ng-change=\"jsTrackingCode.updateTrackingCode()\"
                                 disabled=\"jsTrackingCode.isLoading\"
                                 title=\"{{ 'CoreAdminHome_JSTracking_CampaignKwdParam'|translate|e('html_attr') }}\"
                                 value=\"\">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div id=\"javascript-output-section\">
            <h3>{{ 'General_JsTrackingTag'|translate }}</h3>

            <p>{{ 'CoreAdminHome_JSTracking_CodeNoteBeforeClosingHead'|translate(\"&lt;/head&gt;\")|raw }}</p>

            <div id=\"javascript-text\">
                <pre piwik-select-on-focus class=\"codeblock\"
                     ng-bind=\"jsTrackingCode.trackingCode\"> </pre>
            </div>
        </div>
    </div>
</div>

<div piwik-content-block content-title=\"{{ 'CoreAdminHome_ImageTracking'|translate|e('html_attr') }}\"
     anchor=\"imageTracking\">
    <a name=\"image-tracking-link\"></a>

    <div id=\"image-tracking-code-options\" ng-controller=\"ImageTrackingCodeController as imageTrackingCode\">

        <p>
            {{ 'CoreAdminHome_ImageTrackingIntro1'|translate }} {{ 'CoreAdminHome_ImageTrackingIntro2'|translate(\"<code>&lt;noscript&gt;&lt;/noscript&gt;</code>\")|raw }}
        </p>
        <p>
            {{ 'CoreAdminHome_ImageTrackingIntro3'|translate('<a href=\"https://matomo.org/docs/tracking-api/reference/\" rel=\"noreferrer noopener\" target=\"_blank\">','</a>')|raw }}
        </p>

        {# website #}
        <div piwik-field uicontrol=\"site\" name=\"image-tracker-website\"
             ng-model=\"imageTrackingCode.site\"
             ng-change=\"imageTrackingCode.changeSite(true)\"
             introduction=\"{{ 'General_Website'|translate|e('html_attr') }}\"
             value='{{ defaultSite|json_encode }}'>
        </div>

        {# action_name #}
        <div piwik-field uicontrol=\"text\" name=\"image-tracker-action-name\"
             ng-model=\"imageTrackingCode.pageName\"
             ng-change=\"imageTrackingCode.updateTrackingCode()\"
             disabled=\"imageTrackingCode.isLoading\"
             introduction=\"{{ 'General_Options'|translate|e('html_attr') }}\"
             title=\"{{ 'Actions_ColumnPageName'|translate|e('html_attr') }}\"
             value=\"\">
        </div>

        {# goal #}
        <div piwik-field uicontrol=\"checkbox\" name=\"image-tracking-goal-check\"
             ng-model=\"imageTrackingCode.trackGoal\"
             ng-change=\"imageTrackingCode.updateTrackingCode()\"
             disabled=\"imageTrackingCode.isLoading\"
             title=\"{{ 'CoreAdminHome_TrackAGoal'|translate|e('html_attr') }}\"
             value=\"\">
        </div>

        <div ng-show=\"imageTrackingCode.trackGoal\"
             id=\"image-tracking-goal-sub\">
            <div class=\"row\">
                <div class=\"col s12 m6\">
                    <div piwik-field uicontrol=\"select\" name=\"image-tracker-goal\"
                         options=\"imageTrackingCode.allGoals\"
                         disabled=\"imageTrackingCode.isLoading\"
                         ng-model=\"imageTrackingCode.trackIdGoal\"
                         full-width=\"true\"
                         ng-change=\"imageTrackingCode.updateTrackingCode()\"
                         value=\"\">
                    </div>
                </div>
                <div class=\"col s12 m6\">
                    <div piwik-field uicontrol=\"text\" name=\"image-revenue\"
                         ng-model=\"imageTrackingCode.revenue\"
                         ng-change=\"imageTrackingCode.updateTrackingCode()\"
                         disabled=\"imageTrackingCode.isLoading\"
                         full-width=\"true\"
                         title=\"{{ 'CoreAdminHome_WithOptionalRevenue'|translate|e('html_attr') }} <span class='site-currency'></span>\"
                         value=\"\">
                    </div>
                </div>
            </div>
        </div>

        <div id=\"image-link-output-section\">
            <h3>{{ 'CoreAdminHome_ImageTrackingLink'|translate }}</h3>

            <div id=\"image-tracking-text\">
                <pre piwik-select-on-focus
                          ng-bind=\"imageTrackingCode.trackingCode\"> </pre>
            </div>
        </div>
    </div>
</div>

<div piwik-content-block content-title=\"{{ 'CoreAdminHome_ImportingServerLogs'|translate|e('html_attr') }}\"
     anchor=\"importServerLogs\">
    <p>
        {{ 'CoreAdminHome_ImportingServerLogsDesc'|translate('<a href=\"https://matomo.org/log-analytics/\" rel=\"noreferrer noopener\" target=\"_blank\">','</a>')|raw }}
    </p>
</div>

<div piwik-content-block content-title=\"{{ 'SitesManager_MobileAppsAndSDKs'|translate }}\" anchor=\"mobileAppsAndSdks\">
    <p>{{ 'SitesManager_MobileAppsAndSDKsDescription'|translate('<a href=\"https://matomo.org/integrate/#programming-language-platforms-and-frameworks\" rel=\"noreferrer noopener\" target=\"_blank\">','</a>')|raw }}</p>
</div>

<div piwik-content-block content-title=\"{{ 'CoreAdminHome_HttpTrackingApi'|translate }}\" anchor=\"trackingApi\">
    <p>{{ 'CoreAdminHome_HttpTrackingApiDescription'|translate('<a href=\"https://developer.matomo.org/api-reference/tracking-api\" rel=\"noreferrer noopener\" target=\"_blank\">','</a>')|raw }}</p>
</div>

{{ postEvent('Template.endTrackingCodePage') }}

{% endblock %}
", "@CoreAdminHome/trackingCodeGenerator.twig", "/data/www/work/piwik/plugins/CoreAdminHome/templates/trackingCodeGenerator.twig");
    }
}
