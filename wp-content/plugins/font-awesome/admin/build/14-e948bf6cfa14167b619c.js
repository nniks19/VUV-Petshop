(window.webpackJsonp_font_awesome_admin=window.webpackJsonp_font_awesome_admin||[]).push([[14],{164:function(e,t,n){"use strict";n.r(t),n.d(t,"CONFLICT_DETECTION_SCANNER_DURATION_MIN",(function(){return m})),n.d(t,"resetPendingOptions",(function(){return P})),n.d(t,"resetOptionsFormState",(function(){return y})),n.d(t,"addPendingOption",(function(){return D})),n.d(t,"updatePendingUnregisteredClientsForDeletion",(function(){return R})),n.d(t,"resetUnregisteredClientsDeletionStatus",(function(){return w})),n.d(t,"resetPendingBlocklistSubmissionStatus",(function(){return A})),n.d(t,"submitPendingUnregisteredClientDeletions",(function(){return v})),n.d(t,"updatePendingBlocklist",(function(){return M})),n.d(t,"submitPendingBlocklist",(function(){return U})),n.d(t,"checkPreferenceConflicts",(function(){return k})),n.d(t,"chooseAwayFromKitConfig",(function(){return j})),n.d(t,"chooseIntoKitConfig",(function(){return F})),n.d(t,"queryKits",(function(){return L})),n.d(t,"submitPendingOptions",(function(){return W})),n.d(t,"updateApiToken",(function(){return B})),n.d(t,"userAttemptToStopScanner",(function(){return K})),n.d(t,"reportDetectedConflicts",(function(){return G})),n.d(t,"snoozeV3DeprecationWarning",(function(){return q})),n.d(t,"setActiveAdminTab",(function(){return X})),n.d(t,"setConflictDetectionScanner",(function(){return x}));var o=n(171),s=n.n(o),r=n(179),c=n.n(r),i=n(29),a=n.n(i),u=n(0),l=n.n(u),d=n(174),f=n.n(d),_=n(167),p=n(150),E=n(166),T=n.n(E);const N=s.a.create(),m=10,O=Object(p.__)("Couldn't save those changes","font-awesome"),g=Object(p.__)("Couldn't check preferences","font-awesome"),h=Object(p.__)("A request to your WordPress server never received a response","font-awesome"),I=Object(p.__)("A request to your WordPress server failed","font-awesome"),S=Object(p.__)("Couldn't start the scanner","font-awesome"),b=Object(p.__)("Couldn't snooze","font-awesome");function C(e){const t=T()(e,"headers.fontawesome-confirmation");if(204===e.status&&""!==e.data)return Object(_.b)({error:null,confirmed:t,trimmed:e.data,expectEmpty:!0}),e.data={},e;const n=l()(e,"data",null),o="string"==typeof n&&a()(n)>0,s=o?function(e){if(!e||""===e)return null;const t=function e(t,n=0){let o=null,s=null;if("string"!=typeof t)return null;if(n>=t.length)return null;try{return o=JSON.parse(t.slice(n)),{start:n,parsed:o}}catch(e){const o=t.indexOf("[",n+1),r=t.indexOf("{",n+1);if(-1===o&&-1===r)return null;s=-1!==o&&-1!==r?o<r?o:r:-1!==r?r:o}return null===s?null:e(t,s)}(e);if(null===t)return null;{const{start:n,parsed:o}=t;return{start:n,json:e.slice(n),trimmed:e.slice(0,n),parsed:o}}}(n):{};if(o){if(null===s)return Object(_.b)({error:null,confirmed:t,trimmed:n}),e.data={},e;e.data=l()(s,"parsed")}const r=l()(s,"trimmed",""),c=l()(e,"data.errors",null);if(e.status>=400)return e.uiMessage=c?Object(_.b)({error:e.data,confirmed:t,trimmed:r}):Object(_.b)({error:null,confirmed:t,trimmed:r}),e;if(e.status<400&&e.status>=300)return t&&""===r||(e.uiMessage=Object(_.b)({error:null,confirmed:t,trimmed:r})),e;if(c){const n=!0;return e.falsePositive=!0,e.uiMessage=Object(_.b)({error:e.data,confirmed:t,falsePositive:n,trimmed:r}),e}{const n=l()(e,"data.error",null);return n?(e.uiMessage=Object(_.b)({error:n,ok:!0,confirmed:t,trimmed:r}),e):(t||(e.uiMessage=Object(_.b)({error:null,ok:!0,confirmed:t,trimmed:r})),e)}}function P(){return{type:"RESET_PENDING_OPTIONS"}}function y(){return{type:"OPTIONS_FORM_STATE_RESET"}}function D(e){return function(t,n){const{options:o}=n();for(const[n,s]of c()(e))t(o[n]===s?{type:"RESET_PENDING_OPTION",change:{[n]:s}}:{type:"ADD_PENDING_OPTION",change:{[n]:s}})}}function R(e=[]){return{type:"UPDATE_PENDING_UNREGISTERED_CLIENTS_FOR_DELETION",data:e}}function w(){return{type:"DELETE_UNREGISTERED_CLIENTS_RESET"}}function A(){return{type:"BLOCKLIST_UPDATE_RESET"}}function v(){return function(e,t){const{apiNonce:n,apiUrl:o,unregisteredClientsDeletionStatus:s}=t(),r=l()(s,"pending",null);if(!r||0===a()(r))return;e({type:"DELETE_UNREGISTERED_CLIENTS_START"});const c=({uiMessage:t})=>{e({type:"DELETE_UNREGISTERED_CLIENTS_END",success:!1,message:t||O})};return N.delete(o+"/conflict-detection/conflicts",{data:r,headers:{"X-WP-Nonce":n}}).then(t=>{const{status:n,data:o,falsePositive:s}=t;s?c(t):e({type:"DELETE_UNREGISTERED_CLIENTS_END",success:!0,data:204===n?null:o,message:""})}).catch(c)}}function M(e=[]){return{type:"UPDATE_PENDING_BLOCKLIST",data:e}}function U(){return function(e,t){const{apiNonce:n,apiUrl:o,blocklistUpdateStatus:s}=t(),r=l()(s,"pending",null);if(!r)return;e({type:"BLOCKLIST_UPDATE_START"});const c=({uiMessage:t})=>{e({type:"BLOCKLIST_UPDATE_END",success:!1,message:t||O})};return N.put(o+"/conflict-detection/conflicts/blocklist",r,{headers:{"X-WP-Nonce":n}}).then(t=>{const{status:n,data:o,falsePositive:s}=t;s?c(t):e({type:"BLOCKLIST_UPDATE_END",success:!0,data:204===n?null:o,message:""})}).catch(c)}}function k(){return function(e,t){e({type:"PREFERENCE_CHECK_START"});const{apiNonce:n,apiUrl:o,options:s,pendingOptions:r}=t(),c=({uiMessage:t})=>{e({type:"PREFERENCE_CHECK_END",success:!1,message:t||g})};return N.post(o+"/preference-check",{...s,...r},{headers:{"X-WP-Nonce":n}}).then(t=>{const{data:n,falsePositive:o}=t;o?c(t):e({type:"PREFERENCE_CHECK_END",success:!0,message:"",detectedConflicts:n})}).catch(c)}}function j({activeKitToken:e}){return function(t,n){const{releases:o}=n();t({type:"CHOOSE_AWAY_FROM_KIT_CONFIG",activeKitToken:e,concreteVersion:l()(o,"latest_version")})}}function F(){return{type:"CHOOSE_INTO_KIT_CONFIG"}}function L(){return function(e,t){const{apiNonce:n,apiUrl:o,options:s}=t(),r=l()(s,"kitToken",null);e({type:"KITS_QUERY_START"});const c=({uiMessage:t})=>{e({type:"KITS_QUERY_END",success:!1,message:t||Object(p.__)("Failed to fetch kits","font-awesome")})},i=({uiMessage:t})=>{e({type:"OPTIONS_FORM_SUBMIT_END",success:!1,message:t||Object(p.__)("Couldn't update latest kit settings","font-awesome")})};return N.post(o+"/api","query {\n        me {\n          kits {\n            name\n            version\n            technologySelected\n            licenseSelected\n            minified\n            token\n            shimEnabled\n            autoAccessibilityEnabled\n            status\n          }\n        }\n      }",{headers:{"X-WP-Nonce":n}}).then(t=>{if(t.falsePositive)return c(t);const a=l()(t,"data.data");if(!l()(a,"me"))return e({type:"KITS_QUERY_END",success:!1,message:Object(p.__)("Failed to fetch kits. Regenerate your API Token and try again.","font-awesome")});if(e({type:"KITS_QUERY_END",data:a,success:!0}),!r)return;const u=l()(a,"me.kits",[]),d=f()(u,{token:r});if(!d)return;const _={};return s.usePro&&"pro"!==d.licenseSelected?_.usePro=!1:s.usePro||"pro"!==d.licenseSelected||(_.usePro=!0),"svg"===s.technology&&"svg"!==d.technologySelected?(_.technology="webfont",_.pseudoElements=!0):"svg"!==s.technology&&"svg"===d.technologySelected&&(_.technology="svg",_.pseudoElements=!1),s.version!==d.version&&(_.version=d.version),s.compat&&!d.shimEnabled?_.compat=!1:!s.compat&&d.shimEnabled&&(_.compat=!0),e({type:"OPTIONS_FORM_SUBMIT_START"}),N.put(o+"/config",{options:{...s,..._}},{headers:{"X-WP-Nonce":n}}).then(t=>{const{data:n,falsePositive:o}=t;if(o)return i(t);e({type:"OPTIONS_FORM_SUBMIT_END",data:n,success:!0,message:Object(p.__)("Kit changes saved","font-awesome")})}).catch(i)}).catch(c)}}function W(){return function(e,t){const{apiNonce:n,apiUrl:o,options:s,pendingOptions:r}=t();e({type:"OPTIONS_FORM_SUBMIT_START"});const c=({uiMessage:t})=>{e({type:"OPTIONS_FORM_SUBMIT_END",success:!1,message:t||O})};return N.put(o+"/config",{options:{...s,...r}},{headers:{"X-WP-Nonce":n}}).then(t=>{const{data:n,falsePositive:o}=t;o?c(t):e({type:"OPTIONS_FORM_SUBMIT_END",data:n,success:!0,message:Object(p.__)("Changes saved","font-awesome")})}).catch(c)}}function B({apiToken:e=!1,runQueryKits:t=!1}){return function(n,o){const{apiNonce:s,apiUrl:r,options:c}=o();n({type:"OPTIONS_FORM_SUBMIT_START"});const i=({uiMessage:e})=>{n({type:"OPTIONS_FORM_SUBMIT_END",success:!1,message:e||O})};return N.put(r+"/config",{options:{...c,apiToken:e}},{headers:{"X-WP-Nonce":s}}).then(e=>{const{data:o,falsePositive:s}=e;if(s)i(e);else if(n({type:"OPTIONS_FORM_SUBMIT_END",data:o,success:!0,message:Object(p.__)("API Token saved","font-awesome")}),t)return n(L())}).catch(i)}}function K(){return{type:"USER_STOP_SCANNER"}}function G({nodesTested:e={}}){return(t,n)=>{const{apiNonce:o,apiUrl:s,unregisteredClients:r,showConflictDetectionReporter:c}=n();if(c){if(a()(e.conflict)>0){const n=Object.keys(e.conflict).reduce((function(t,n){return t[n]=e.conflict[n],t}),{});t({type:"CONFLICT_DETECTION_SUBMIT_START",unregisteredClientsBeforeDetection:r,recentConflictsDetected:e.conflict});const c=({uiMessage:e})=>{t({type:"CONFLICT_DETECTION_SUBMIT_END",success:!1,message:e||O})};return N.post(s+"/conflict-detection/conflicts",n,{headers:{"X-WP-Nonce":o}}).then(e=>{const{status:n,data:o,falsePositive:s}=e;s?c(e):t({type:"CONFLICT_DETECTION_SUBMIT_END",success:!0,data:204===n||0===a()(o)?null:o})}).catch(c)}t({type:"CONFLICT_DETECTION_NONE_FOUND"})}}}function q(){return(e,t)=>{const{apiNonce:n,apiUrl:o}=t();e({type:"SNOOZE_V3DEPRECATION_WARNING_START"});const s=({uiMessage:t})=>{e({type:"SNOOZE_V3DEPRECATION_WARNING_END",success:!1,message:t||b})};return N.put(o+"/v3deprecation",{snooze:!0},{headers:{"X-WP-Nonce":n}}).then(t=>{const{falsePositive:n}=t;n?s(t):e({type:"SNOOZE_V3DEPRECATION_WARNING_END",success:!0,snooze:!0,message:""})}).catch(s)}}function X(e){return{type:"SET_ACTIVE_ADMIN_TAB",tab:e}}function x({enable:e=!0}){return function(t,n){const{apiNonce:o,apiUrl:s}=n(),r=e?"ENABLE_CONFLICT_DETECTION_SCANNER_END":"DISABLE_CONFLICT_DETECTION_SCANNER_END";t({type:e?"ENABLE_CONFLICT_DETECTION_SCANNER_START":"DISABLE_CONFLICT_DETECTION_SCANNER_START"});const c=({uiMessage:e})=>{t({type:r,success:!1,message:e||S})};return N.put(s+"/conflict-detection/until",e?Math.floor(new Date((new Date).valueOf()+1e3*m*60)/1e3):Math.floor(new Date/1e3)-1,{headers:{"X-WP-Nonce":o}}).then(e=>{const{status:n,data:o,falsePositive:s}=e;s?c(e):t({type:r,data:204===n?null:o,success:!0})}).catch(c)}}N.interceptors.response.use(e=>C(e),e=>{if(e.response)e.response=C(e.response),e.uiMessage=l()(e,"response.uiMessage");else if(e.request){const t="fontawesome_request_noresponse",n={errors:{[t]:[h]},error_data:{[t]:{request:e.request}}};e.uiMessage=Object(_.b)({error:n})}else{const t="fontawesome_request_failed",n={errors:{[t]:[I]},error_data:{[t]:{failedRequestMessage:e.message}}};e.uiMessage=Object(_.b)({error:n})}return Promise.reject(e)})},167:function(e,t,n){"use strict";n.d(t,"a",(function(){return a}));var o=n(0),s=n.n(o),r=n(29),c=n.n(r),i=n(150);const a=Object(i.__)("Font Awesome WordPress Plugin Error Report","font-awesome"),u=Object(i.__)("D'oh! That failed big time.","font-awesome"),l=Object(i.__)("There was an error attempting to report the error.","font-awesome"),d=Object(i.__)("Oh no! Your web browser could not reach your WordPress server.","font-awesome"),f=Object(i.__)("It looks like your web browser session expired. Try logging out and log back in to WordPress admin.","font-awesome"),_=Object(i.__)("The last request was successful, but it also returned the following error(s), which might be helpful for troubleshooting.","font-awesome"),p=Object(i.__)("Error","font-awesome"),E=Object(i.__)("WARNING: The last request contained errors, though your WordPress server reported it as a success. This usually means there's a problem with your theme or one of your other plugins emitting output that is causing problems.","font-awesome"),T=Object(i.__)("WARNING: The last response from your WordPress server did not include the confirmation header that should be in all valid Font Awesome responses. This is a clue that some code from another theme or plugin is acting badly and causing the wrong headers to be sent.","font-awesome"),N=Object(i.__)("WARNING: Invalid Data Trimmed from Server Response","font-awesome"),m=Object(i.__)("WARNING: We expected the last response from the server to contain no data, but it contained something unexpected.","font-awesome"),O=Object(i.__)("Your WordPress server returned an error for that last request, but there was no information about the error.","font-awesome");t.b=function(e){const{error:t,ok:n=!1,falsePositive:o=!1,confirmed:r=!0,expectEmpty:i=!1,trimmed:g=""}=e;console.group(a),n&&console.info(_),o&&console.info(E),r||console.info(T),""!==g&&(console.group(N),i&&console.info(m),console.info(g),console.groupEnd());const h=null!==t?function(e){const t=Object.keys(e.errors||[]).map(t=>({code:t,message:s()(e,`errors.${t}.0`),data:s()(e,"error_data."+t)}));return 0===c()(t)&&t.push({code:"fontawesome_unknown_error",message:l}),t.reduce((e,t)=>{console.group(p);const n=function(e){if(!s()(e,"code"))return console.info(l),u;let t=null,n="";const o=s()(e,"message");o&&(n=n.concat(`message: ${o}\n`),t=o);const r=s()(e,"code");if(r)switch(n=n.concat(`code: ${r}\n`),r){case"rest_no_route":t=d;break;case"rest_cookie_invalid_nonce":t=f;break;case"fontawesome_unknown_error":t=u}const c=s()(e,"data");if("string"==typeof c)n=n.concat(`data: ${c}\n`);else{const t=s()(e,"data.status");t&&(n=n.concat(`status: ${t}\n`));const o=s()(e,"data.trace");o&&(n=n.concat(`trace:\n${o}\n`))}n&&""!==n?console.info(n):console.info(e);const i=s()(e,"data.request");i&&console.info(i);const a=s()(e,"data.failedRequestMessage");return a&&console.info(a),t}(t);return console.groupEnd(),e||"previous_exception"===t.code?e:n},null)}(t):null;return null===t&&""===g&&r&&console.info(O),console.groupEnd(),h}}}]);