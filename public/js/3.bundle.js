(window.webpackJsonp=window.webpackJsonp||[]).push([[3],{186:function(t,e,a){"use strict";var r=a(2),s=a(17),i=a(22);e.a=Object(r.a)(s.a,Object(i.b)("form")).extend({name:"v-form",inheritAttrs:!1,props:{lazyValidation:Boolean,value:Boolean},data:()=>({inputs:[],watchers:[],errorBag:{}}),watch:{errorBag:{handler(t){const e=Object.values(t).includes(!0);this.$emit("input",!e)},deep:!0,immediate:!0}},methods:{watchInput(t){const e=t=>t.$watch("hasError",e=>{this.$set(this.errorBag,t._uid,e)},{immediate:!0}),a={_uid:t._uid,valid:()=>{},shouldValidate:()=>{}};return this.lazyValidation?a.shouldValidate=t.$watch("shouldValidate",r=>{r&&(this.errorBag.hasOwnProperty(t._uid)||(a.valid=e(t)))}):a.valid=e(t),a},validate(){return 0===this.inputs.filter(t=>!t.validate(!0)).length},reset(){this.inputs.forEach(t=>t.reset()),this.resetErrorBag()},resetErrorBag(){this.lazyValidation&&setTimeout(()=>{this.errorBag={}},0)},resetValidation(){this.inputs.forEach(t=>t.resetValidation()),this.resetErrorBag()},register(t){this.inputs.push(t),this.watchers.push(this.watchInput(t))},unregister(t){const e=this.inputs.find(e=>e._uid===t._uid);if(!e)return;const a=this.watchers.find(t=>t._uid===e._uid);a&&(a.valid(),a.shouldValidate()),this.watchers=this.watchers.filter(t=>t._uid!==e._uid),this.inputs=this.inputs.filter(t=>t._uid!==e._uid),this.$delete(this.errorBag,e._uid)}},render(t){return t("form",{staticClass:"v-form",attrs:{novalidate:!0,...this.attrs$},on:{submit:t=>this.$emit("submit",t)}},this.$slots.default)}})},192:function(t,e,a){"use strict";a.d(e,"a",(function(){return r}));var r={data:function(){return{dialog:!1,toast:!1,toastText:"",requesting:!1,showDeleteDialog:!1,activeResource:{name:null}}},methods:{notify:function(t){this.toastText=t,this.toast=!0}}}},196:function(t,e,a){"use strict";a.r(e);var r={name:"Donors",mixins:[a(192).a],data:function(){return{loading:!0,bloodTypeSelect:[],stats:[{name:"Donors",value:0,color:"green",icon:"person"}],donors:[],headers:[{text:"Name",value:"name"},{text:"Phone",value:"phone"},{text:"Community",value:"community"},{text:"Blood Type",value:"blood_type"},{text:"Badge",value:"badge"}]}},created:function(){var t=this;this.$dash.resource("donors").get("",(function(e){if(e.data){var a=e.data.map((function(t){return{id:t.id,name:t.attributes.firstname+" "+t.attributes.lastname,phone:t.attributes.phone,community:t.relationships.community.name,blood_type:t.relationships.blood_type.name,badge:t.relationships.badge.name}}));t.donors=a,t.loading=!1,t.stats[0].value=t.donors.length}})),this.$dash.resource("blood_types").get("",(function(e){e.data&&(t.bloodTypeSelect=e.data)}))}},s=a(15),i=a(16),o=a.n(i),n=a(47),l=a(42),d=a(21),u=a(191),c=a(186),h=a(65),v=a(150),p=a(39),m=Object(s.a)(r,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("page",{attrs:{name:"Donors",desc:"Manage all donors"},scopedSlots:t._u([{key:"tools",fn:function(){return[a("v-dialog",{attrs:{persistent:"","max-width":"600px"},scopedSlots:t._u([{key:"activator",fn:function(e){var r=e.on;return[a("v-btn",t._g({attrs:{color:"primary"}},r),[t._v("New ")])]}}]),model:{value:t.dialog,callback:function(e){t.dialog=e},expression:"dialog"}},[t._v(" "),a("v-card",[a("v-card-title",{staticClass:"headline font-weight-bold grey lighten-2"},[t._v("\n\t\t\t\t\tNew Donor\n\t\t\t\t")]),t._v(" "),a("v-form",{ref:"newUser",attrs:{id:"new-user-form"}},[a("v-card-text",[a("v-text-field",{attrs:{label:"Name",name:"name",required:""}}),t._v(" "),a("v-text-field",{attrs:{label:"Phone",name:"phone",required:""}}),t._v(" "),a("v-text-field",{attrs:{label:"Password",type:"password",name:"password",required:""}}),t._v(" "),a("v-select",{attrs:{items:t.bloodTypeSelect,label:"Blood Type",name:"blood_type",filled:"",required:""}})],1),t._v(" "),a("v-card-actions",[a("v-spacer"),t._v(" "),a("v-btn",{attrs:{color:"black",text:""},on:{click:function(e){t.dialog=!1}}},[t._v("Close")]),t._v(" "),a("v-btn",{attrs:{loading:t.requesting,color:"primary",type:"submit"}},[t._v("Save")])],1)],1)],1)],1),t._v(" "),a("delete-dialog",{attrs:{show:t.showDeleteDialog,toDelete:t.activeResource.name,resourceType:"User"},on:{delete:t.deleteResource}})]},proxy:!0}])},[t._v(" "),a("stat-card",{attrs:{stats:t.stats}}),t._v(" "),a("Table",{attrs:{headers:t.headers,items:t.donors,loading:t.loading}})],1)}),[],!1,null,null,null);e.default=m.exports;o()(m,{VBtn:n.a,VCard:l.a,VCardActions:d.a,VCardText:d.b,VCardTitle:d.c,VDialog:u.a,VForm:c.a,VSelect:h.a,VSpacer:v.a,VTextField:p.a})}}]);