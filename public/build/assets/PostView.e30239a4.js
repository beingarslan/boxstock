import{_ as u,r as m,S as d,p as f,X as _,Y as h,o as e,c as s,b as a,f as p,t as l,e as v}from"./app.67f4f754.js";const g=m(!1),x={components:{moment:d},setup(){const o=m(),n=(t,i)=>{v.get("/posts/"+i,{headers:{Authorization:"Bearer "+t}}).then(c=>{o.value=c.data.post})},r=t=>{if(t)return d(String(t)).format("DD / MM / YYYY")};return f(()=>{let t=localStorage.getItem("token");_.currentRoute._value.params.slug!=="undefined"&&n(t,_.currentRoute._value.params.slug)}),{data:o,visible:g,avatarLink:h,format_date:r}}},k={class:"retailers"},b={class:"container"},y={class:"main-content mt-[50px] mb-[100px]"},M={key:0},Y={key:0,class:"mb-[20px]"},w=["src","alt"],B={class:"user_info"},L={class:"flex items-center gap-[10px] mb-[50px]"},S=["src","alt"],V={class:"block font-medium font-[16px]"},D={class:"block font-medium font-[16px]"},P=["innerHTML"],H={key:1,class:"loader_wrapper_"},N=a("span",{class:"loader"},null,-1),R=[N];function T(o,n,r,t,i,c){return e(),s("div",k,[a("div",b,[a("div",y,[t.data?(e(),s("div",M,[t.data.image?(e(),s("div",Y,[a("img",{src:t.data.image,alt:t.data.title},null,8,w)])):p("",!0),a("div",B,[a("div",L,[a("div",null,[a("img",{class:"rounded-full w-[40px] h-[40px]",src:t.data.user.image?t.data.user.image:t.avatarLink,alt:t.data.user.user_name},null,8,S)]),a("div",null,[a("span",V,l(t.data.user.user_name),1),a("span",D,l(t.format_date(t.data.updated_at)),1)])]),a("div",{innerHTML:t.data.content},null,8,P)])])):(e(),s("div",H,R))])])])}const A=u(x,[["render",T]]);export{A as default};