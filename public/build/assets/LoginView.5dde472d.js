import{r as i,G as y,a as T,o as l,c as d,b as e,d as t,w as m,u as s,e as k,X as A,t as u,f as x,g as D,v as C,h as c}from"./app.67f4f754.js";import{c as S,a as f,F as L,d as _,E as h}from"./object.051b359d.js";import{S as q}from"./sweetalert2.all.83a80c41.js";const E={class:"mb-[200px]"},R={class:"login-form-wrapper mt-[6px] mb-[6px] pt-[60px]"},V={class:"container"},j={class:"form-wrapper mx-auto mt-[33px] justify-center items-center lg:flex"},B={class:"form-hear"},N=e("h2",{class:"font-[TTCommons] text-[#555555] text-[34px] font-[400px] leading-[32px]"},"Log in",-1),F={class:"input-wrrapper pt-[20px]"},P=e("label",{class:"block text-[#000] font-medium font-[TTCommons] text-[14px] font-[400] leading-4"},"Email",-1),G={key:0,role:"alert",class:"text-red-700"},M={class:"input-wrrapper pt-[20px]"},O=e("label",{class:"block text-[#000] font-medium font-[TTCommons] text-[14px] font-[400] leading-4"},"Password",-1),U={key:0,role:"alert",class:"text-red-700"},X=e("div",{class:"form-check mt-[23px]"},[e("label",{class:"flex items-center form-check-label text-gray-800 font-bold"},[e("input",{class:"form-check-input border-[#DADADA] h-4 w-4 border transiton duration-200 rounded-sm outline-none align-top bg-center bg-contain float-left mr-2 cursor-pointer pl-[15px]",required:"",type:"checkbox",value:"Remember me"}),c(" Remember me ")])],-1),$=["disabled"],z={class:"loader_wrraper"},H=e("span",{class:"loader"},null,-1),I=[H],J=c(" Login "),K={class:"flex justify-between items-center"},Q=c("Registreer"),se={name:"LoginView",setup(W){const b=S().shape({email:f().required("This field is required").email(),password:f().required("This field is required").min(6)}),o=i(!1),r=i([]);i(!1),i();const p=y();function g(n){q.fire(n,"","error")}function v(n){o.value=!0,k({method:"POST",url:"/auth/login",headers:{"Content-Type":"application/json"},data:n}).then(a=>{o.value=!1,p.dispatch("setToken",a.data.access_token),p.dispatch("setUser",a.data.user),A.push("/order-list")}).catch(a=>{console.log(a),g("Something went wrong please try again latter"),o.value=!1})}return(n,a)=>{const w=T("RouterLink");return l(),d("section",E,[e("div",R,[e("div",V,[e("div",j,[e("div",B,[N,t(s(L),{onSubmit:v,"validation-schema":s(b)},{default:m(({isSubmitting:Y})=>[e("div",F,[P,t(s(_),{class:"mt-[10px] py-[18px] rounded-[5px] w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px]",placeholder:"Email adress",name:"email",type:"email"}),t(s(h),{class:"text-red-700",name:"email"}),r.value.email?(l(),d("span",G,u(r.value.email[0]),1)):x("",!0)]),e("div",M,[O,t(s(_),{class:"mt-[10px] py-[18px] rounded-[5px] w-[100%] outline-none border border-[#DADADA] bg-[#fff] px-[17px]",placeholder:"Password",name:"password",type:"password"}),t(s(h),{class:"text-red-700",name:"password"}),r.value.password?(l(),d("span",U,u(r.value.password[0]),1)):x("",!0)]),X,e("div",null,[e("button",{type:"submit",class:"!text-[#fff] w-full lg:w-[520px] mt-[30px] h-[54px] bg-[#111010] relative rounded-[50px] font-[TTCommons] text-[22px] font-[700] tracking-[0.266667px] leading-[26px] text-[#fff] px-[14px]",disabled:o.value},[D(e("div",z,I,512),[[C,o.value]]),J],8,$)]),e("div",K,[t(w,{class:"flex justify-end mt-[13px] font-[TTCommons] text-[18px] font-bold leading-[34px] text-[#00B67A]",to:"/register"},{default:m(()=>[Q]),_:1})])]),_:1},8,["validation-schema"])])])])])])}}};export{se as default};