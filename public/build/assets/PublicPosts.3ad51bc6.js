import{_ as L,r as e,S as b,p as A,a as g,o as i,c as _,b as o,d as v,W as D,w as u,e as w,A as S,f as B,t as p,h as M}from"./app.67f4f754.js";const P=e(!1),C={components:{moment:b},setup(){const l=e(),h=e(!0),r=e(!1),t=e(),d=e([]),x=e(""),m=e([]);let a=e(1);const f=n=>{w.get("/posts/?page="+a.value,{headers:{Authorization:"Bearer "+n}}).then(c=>{h.value=!1,console.log(c),l.value=c.data.posts.data,d.value=c.data.posts.data,t.value=c.data.posts.total})},s=n=>{if(n)return b(String(n)).format("DD / MM / YYYY")},y=()=>{r.value=!0,a.value=a.value+1,d.value=l.value.concat([...new Array(a.value)].map(()=>({loading:!0,name:{},picture:{}})));let n=localStorage.getItem("token");w.get("/posts?page="+a.value,{headers:{Authorization:"Bearer "+n}}).then(c=>{const k=l.value.concat(c.data.posts.data);r.value=!1,l.value=k,d.value=k,S(()=>{window.dispatchEvent(new Event("resize"))})})};return A(()=>{let n=localStorage.getItem("token");f(n)}),{posts:l,visible:P,format_date:s,initLoading:h,loading:r,totalProduct:t,value:x,dataSource:m,page:a,list:d,onLoadMore:y}}},z={class:"retailers"},N={class:"container"},V={class:"main-content mt-[50px] mb-[100px]"},Y={key:0},E={key:0,class:"mt-[115px] text-center loading-button"},I=M("Load more"),R={class:"p-3 cursor-pointer overflow-hidden"},T={class:"sneakers-card h-full w-full bg-white transform transition duration-500 rounded border border-[#DADADA] hover:shadow-xl hover:border-[#ffffff]"},W=["src"],j={class:"content px-[15px]"},q={class:"text-[#555555] font-medium inline-block text-[18px] mt-[15px]"},F={class:"font-bold text-[18px] mt-[15px]"},G={class:"text-[#555555]"},H={key:1,class:"loader_wrapper_"},J=o("span",{class:"loader"},null,-1),K=[J];function O(l,h,r,t,d,x){const m=g("a-button"),a=g("RouterLink"),f=g("a-list");return i(),_("div",z,[o("div",N,[o("div",V,[t.loading?(i(),_("div",H,K)):(i(),_("div",Y,[v(f,{class:"demo-loadmore-list",loading:t.initLoading,"item-layout":"horizontal","data-source":t.list,grid:{gutter:16,xs:1,sm:2,md:3,lg:3,xl:3,xxl:3,xxxl:3}},D({renderItem:u(({item:s})=>[v(a,{to:"/blog/"+s.slug},{default:u(()=>[o("div",R,[o("div",T,[o("div",null,[o("img",{class:"w-full",src:s.image,alt:"blog-title"},null,8,W)]),o("div",j,[o("span",q,"By "+p(s.user.company_name)+" "+p(t.format_date(s.created_at)),1),o("h4",F,p(s.title),1),o("p",G,p(s.description),1)])])])]),_:2},1032,["to"])]),_:2},[t.page<t.totalProduct&&t.list.length<t.totalProduct?{name:"loadMore",fn:u(()=>[!t.initLoading&&!t.loading?(i(),_("div",E,[v(m,{onClick:t.onLoadMore,class:"font-[700]"},{default:u(()=>[I]),_:1},8,["onClick"])])):B("",!0)])}:void 0]),1032,["loading","data-source"])]))])])])}const U=L(C,[["render",O]]);export{U as default};
