import{_ as T,r as u,z as V,a8 as E,p as H,e as f,a as d,o as x,c as y,b as r,d as l,w as o,ab as b,t as z,f as g,Q as C,h as c}from"./app.67f4f754.js";const p=u(!1),h=u(),S=u(),w=u(),D=()=>{h.value="Add new sizes",p.value=!0},U=a=>{h.value="Edit sizes",p.value=!0;let t=localStorage.getItem("token");t&&f.get("/sizes/"+a+"/edit",{headers:{Authorization:"Bearer "+t}}).then(i=>{_.name=i.data.size.name,w.value=i.data.size.id})},L=a=>{p.value=!1;let t=localStorage.getItem("token");f({method:"PUT",url:"/sizes/"+a,headers:{Authorization:"Bearer "+t},data:b(_)}).then(i=>{B(),window.location.reload()})},O=a=>{let t=localStorage.getItem("token");f({method:"DELETE",url:"/sizes/"+a,headers:{Authorization:"Bearer "+t}}).then(i=>{window.location.reload()})},_=V({name:""}),P=()=>{if(!_.name)return S.value="Brand name required.",!1;let a=localStorage.getItem("token");f({method:"POST",url:"/sizes/",headers:{Authorization:"Bearer "+a},data:b(_)}).then(t=>{window.location.reload()})},B=()=>{p.value=!1},R={components:{AdminHeaderVue:E},setup(){const a=u();let t=[];return H(()=>{let v=localStorage.getItem("token");f.get("/sizes",{headers:{Authorization:"Bearer "+v}}).then(m=>{a.value=m.data.size,t=m.data.size})}),{data:a,columns:[{title:"Title",dataIndex:"name"},{title:"Action",dataIndex:"operation",slots:{customRender:"operation"}}],visible:p,formState:_,requiredMsg:S,catId:w,editModal:U,modalTitle:h,closeModal:B,onSubmit:P,addCategory:D,updateHandler:L,deleteHandler:O,filterData:t,filterByCategoryName:v=>{a.value=t.filter(m=>m.name.toLowerCase().indexOf(v.target.value.toLowerCase())>-1)}}}},F={class:"retailers"},Q={class:"container"},j={class:"text-right mt-[100px] mb-[10px]"},G=c("Add new"),J={class:"flex items-center flex-wrap gap-[20px] mb-[20px]"},K=r("span",null,"Size name: ",-1),W=c("Edit"),X=c("Delete"),Y={key:0,role:"alert",class:"text-red-700 text-[12px]"},Z=c("Update"),$=c("Save"),ee=c("Cancel");function te(a,t,i,e,v,m){const s=d("a-button"),I=d("a-table"),A=d("a-input"),k=d("a-form-item"),M=d("a-form"),q=d("a-modal");return x(),y("div",F,[r("div",Q,[r("div",j,[l(s,{class:"mr-[10px]",type:"primary",onClick:e.addCategory},{default:o(()=>[G]),_:1},8,["onClick"])]),r("div",J,[r("div",null,[K,r("input",{onInput:t[0]||(t[0]=n=>e.filterByCategoryName(n)),class:"py-[10px] border border-[#f5f5f5] px-[10px]",type:"text",placeholder:"Filter by size name"},null,32)])]),l(I,{columns:e.columns,"data-source":e.data,bordered:""},{name:o(({text:n})=>[r("a",null,z(n),1)]),operation:o(({record:n})=>[l(s,{class:"mr-[10px]",type:"primary",onClick:N=>e.editModal(n.id)},{default:o(()=>[W]),_:2},1032,["onClick"]),l(s,{class:"mr-[10px]",type:"danger",onClick:N=>e.deleteHandler(n.id)},{default:o(()=>[X]),_:2},1032,["onClick"])]),_:1},8,["columns","data-source"])]),l(q,{visible:e.visible,"onUpdate:visible":t[3]||(t[3]=n=>e.visible=n),title:e.modalTitle},{default:o(()=>[l(M,{model:e.formState},{default:o(()=>[l(k,{label:"Size name"},{default:o(()=>[l(A,{"aria-required":"true",required:"required",value:e.formState.name,"onUpdate:value":t[1]||(t[1]=n=>e.formState.name=n)},null,8,["value"]),e.requiredMsg?(x(),y("span",Y,z(e.requiredMsg),1)):g("",!0)]),_:1}),l(k,{"wrapper-col":{span:14,offset:4}},{default:o(()=>[e.catId?(x(),C(s,{key:0,type:"primary",onClick:t[2]||(t[2]=n=>e.updateHandler(e.catId))},{default:o(()=>[Z]),_:1})):g("",!0),e.catId?g("",!0):(x(),C(s,{key:1,type:"primary",onClick:e.onSubmit},{default:o(()=>[$]),_:1},8,["onClick"])),l(s,{style:{"margin-left":"10px"},onClick:e.closeModal},{default:o(()=>[ee]),_:1},8,["onClick"])]),_:1})]),_:1},8,["model"])]),_:1},8,["visible","title"])])}const oe=T(R,[["render",te]]);export{oe as default};
