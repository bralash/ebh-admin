(window.webpackJsonp=window.webpackJsonp||[]).push([[6],{197:function(t,e,a){"use strict";a.r(e);var s={name:"Communities",data:function(){return{loading:!0,stats:[{name:"Communities",color:"grey darken-2",value:0,icon:"place"}],communities:[],headers:[{text:"Name",value:"name"},{text:"Region",value:"region"},{text:"District",value:"district"},{text:"GPS Adress",value:"gps"}]}},created:function(){var t=this;this.$dash.resource("communities").get("",(function(e){if(e.data){var a=e.data.map((function(t){return t.attributes}));t.communities=a,t.loading=!1,t.stats[0].value=t.communities.length}}))}},i=a(18),n=Object(i.a)(s,(function(){var t=this.$createElement,e=this._self._c||t;return e("page",{attrs:{name:"Communities",desc:"Manage all blood requests"}},[e("stat-card",{attrs:{stats:this.stats}}),this._v(" "),e("Table",{attrs:{headers:this.headers,items:this.communities,loading:this.loading}})],1)}),[],!1,null,null,null);e.default=n.exports}}]);