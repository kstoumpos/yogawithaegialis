!function(t){"function"==typeof define&&define.amd?define("onboarding",t):t()}(function(){"use strict";new Vue({el:"#mylisting-onboarding",data:{config:MyListing_Demo_Import_Config,demoImport:{demoKey:"",demo:{},started:!1,done:!1,steps:[],step:"",message:""}},created:function(){},mounted:function(){},methods:{startImport:function(t){var e=this.config.demos[t];e&&confirm('This will download and install the "'.concat(e.name,'" demo. Do you want to proceed?'))&&(this.demoImport.demoKey=t,this.demoImport.demo=e,this.demoImport.started=!0,this.demoImport.done=!1,this.demoImport.steps=Object.keys(this.config.steps).slice(0),this.demoImport.step=this.demoImport.steps.shift(),this.demoImport.message=this.config.steps[this.demoImport.step],this.importNextStep())},importNextStep:function(){var e=this;this.demoImport.step?jQuery.get(CASE27.mylisting_ajax_url,{action:"import_demo",security:CASE27.ajax_nonce,demo:this.demoImport.demoKey,step:this.demoImport.step},function(t){return t&&t.success?(t&&t.data&&t.data.repeat?t.data.message&&(e.demoImport.message="".concat(e.config.steps[e.demoImport.step]," (").concat(t.data.message,")")):(e.demoImport.step=e.demoImport.steps.shift(),e.demoImport.message=e.config.steps[e.demoImport.step]),void e.importNextStep()):(alert(t.data.message),void(e.demoImport.failed=!0))}):this.demoImport.done=!0}}})});
