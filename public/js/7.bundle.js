(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{196:function(t,e,a){"use strict";a.r(e);var n={name:"Donations",data:function(){return{loading:!0,stats:[{name:"Donations made",value:0,color:"primary",icon:"eco"}],donations:[],headers:[{text:"Donor",value:"donor"},{text:"Donation Type",value:"donation_type"},{text:"blood Type",value:"blood_type"},{text:"Volume",value:"volume"},{text:"Stage",value:"stage"},{text:"Event",value:"event"}]}},created:function(){var t=this;this.$dash.resource("donations").get("",(function(e){if(e.data){var a=e.data.map((function(t){return{donor:t.relationships.donor.firstname,donation_type:t.attributes.donation_type,blood_type:t.relationships.blood_type.name,volume:t.attributes.volume,stage:t.attributes.stage,event:t.attributes.event}}));t.loading=!1,t.donations=a,t.stats[0].value=t.donations.length}}))}},o=a(18),s=Object(o.a)(n,(function(){var t=this.$createElement,e=this._self._c||t;return e("page",{attrs:{name:"Donations",desc:"Manage blood donations"}},[e("stat-card",{attrs:{stats:this.stats}}),this._v(" "),e("Table",{attrs:{headers:this.headers,items:this.requests,loading:this.loading}})],1)}),[],!1,null,null,null);e.default=s.exports}}]);