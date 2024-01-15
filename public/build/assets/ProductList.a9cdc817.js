import{_ as F,r as f,a8 as T,a9 as j,aa as D,z as E,p as H,e as g,a as p,o as x,c as U,b as l,d as r,w as d,ab as z,t as V,f as C,Q as M,h as y}from"./app.67f4f754.js";const h=f(!1),N=()=>{h.value=!1},G=k=>{let a=localStorage.getItem("token");g({method:"DELETE",url:"/products/"+k,headers:{Authorization:"Bearer "+a}}).then(w=>{window.location.reload()})},K={components:{AdminHeaderVue:T,LoadingOutlined:j,PlusOutlined:D},setup(){const k=[{title:"",dataIndex:"image",slots:{customRender:"image"}},{title:"Title",dataIndex:"name"},{title:"Price",dataIndex:"amount"},{title:"Category",dataIndex:"category",slots:{customRender:"category"}},{title:"Brand",dataIndex:"brand",slots:{customRender:"brand"}},{title:"Action",dataIndex:"operation",slots:{customRender:"operation"}}],a=f(),w=f(),e=f(),_=f(),A=f();let c="";const b=f("");let m=[];const i=f(),s=E({name:"",sku:"",amount:"",brand_id:"",category_id:"",des:"",product_type:""}),v=n=>{h.value=!0;let o=localStorage.getItem("token");g({method:"GET",url:"/products/"+n,headers:{Authorization:"Bearer "+o}}).then(u=>{e.value=u.data.product.id,s.name=u.data.product.name,b.value=u.data.product.image,s.sku=u.data.product.sku,s.amount=u.data.product.amount,s.des=u.data.product.des,s.category_id=u.data.product.category,s.brand_id=u.data.product.brand,s.product_type=u.data.product.product_type})},S={name:[{required:!0,message:"Please input product name",trigger:"blur"}],des:[{required:!0,message:"Please insert product description",trigger:"blur"}],sku:[{required:!0,message:"Please insert sku",trigger:"blur"}],amount:[{required:!0,message:"Please insert amount",trigger:"blur"}],brand_id:[{required:!0,message:"Please select brand",trigger:"blur"}],category_id:[{required:!0,message:"Please select category",trigger:"blur"}],product_type:[{required:!0,message:"Please select type",trigger:"blur"}]},B=()=>{let n=z(s);n.image=c,i.value.validate().then(()=>{let o=localStorage.getItem("token");g({method:"POST",url:"/products/",headers:{Authorization:"Bearer "+o,"content-type":"multipart/form-data"},data:n}).then(u=>{window.location.reload(),N()})}).catch(o=>{console.log("error",o)})};function P(n){const o=n.target.files[0];c=o,b.value=URL.createObjectURL(o)}const t=()=>{e.value="",s.name="",b.value="",s.sku="",s.amount="",s.des="",s.category_id="",s.brand_id="",s.product_type=""},I=()=>{h.value=!0},R=n=>{let o=localStorage.getItem("token");g({method:"PUT",url:"/products/"+n,headers:{Authorization:"Bearer "+o},data:z(s)}).then(u=>{let q={id:n,type:"product",image:c};g({method:"POST",url:"/image/update",headers:{Authorization:"Bearer "+o,"content-type":"multipart/form-data"},data:q}).then(ye=>{N(),window.location.reload(),h.value=!1})})},O=n=>{g.get("/brands",{headers:{Authorization:"Bearer "+n}}).then(o=>{w.value=o.data.brand})},L=n=>{g.get("/products",{headers:{Authorization:"Bearer "+n}}).then(o=>{_.value=o.data.product,m=o.data.product})};return H(()=>{let n=localStorage.getItem("token");O(n),L(n),g.get("/categories",{headers:{Authorization:"Bearer "+n}}).then(o=>{a.value=o.data.category})}),{data:_,columns:k,visible:h,closeModal:N,updateHandler:R,deleteHandler:G,formRef:i,labelCol:{span:8},wrapperCol:{span:12},other:"",formState:s,rules:S,onSubmit:B,resetForm:t,imageUrl:b,onFileChange:P,getProducts:L,addNewModal:I,categories:a,brands:w,editModal:v,pId:e,product_name:A,filterByProductName:n=>{_.value=m.filter(o=>o.name.toLowerCase().indexOf(n.target.value.toLowerCase())>-1)},filterByCategoryName:n=>{_.value=m.filter(o=>o.category.name.toLowerCase().indexOf(n.target.value.toLowerCase())>-1)},filterByBrandName:n=>{_.value=m.filter(o=>o.brand.name.toLowerCase().indexOf(n.target.value.toLowerCase())>-1)},filterData:m}}},Q={class:"retailers"},J={class:"container"},W={class:"text-right mt-[100px] mb-[10px]"},X=y(" Add new "),Y={class:"flex items-center flex-wrap gap-[20px] mb-[20px]"},Z=l("span",null,"Product name: ",-1),$=l("span",null,"Category name: ",-1),ee=l("span",null,"Brand name: ",-1),te=["src"],ae={class:"flex items-center gap-[15px]"},oe=y("Edit"),re=y("Delete"),le={class:"flex items-center justify-center w-full relative"},ne={key:0,class:"flex flex-col items-center justify-center pt-7"},de=["src"],se={key:1,class:"flex flex-col w-full h-32 border-4 border-blue-200 border-dashed hover:bg-gray-100 hover:border-gray-300"},ie=l("div",{class:"flex flex-col items-center justify-center pt-7"},[l("svg",{xmlns:"http://www.w3.org/2000/svg",class:"w-8 h-8 text-gray-400 group-hover:text-gray-600",fill:"none",viewBox:"0 0 24 24",stroke:"currentColor"},[l("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"})]),l("p",{class:"pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600"},"Upload image")],-1),ue=[ie],ce=y("Update"),me=y("Save"),pe=y("Close");function fe(k,a,w,e,_,A){const c=p("v-btn"),b=p("a-table"),m=p("a-input"),i=p("a-form-item"),s=p("a-textarea"),v=p("v-combobox"),S=p("a-form"),B=p("v-card"),P=p("v-dialog");return x(),U("div",Q,[l("div",J,[l("div",W,[r(c,{onClick:e.addNewModal},{default:d(()=>[X]),_:1},8,["onClick"])]),l("div",Y,[l("div",null,[Z,l("input",{onInput:a[0]||(a[0]=t=>e.filterByProductName(t)),class:"py-[10px] border border-[#f5f5f5] px-[10px]",type:"text",placeholder:"Filter by product name"},null,32)]),l("div",null,[$,l("input",{onInput:a[1]||(a[1]=t=>e.filterByCategoryName(t)),class:"py-[10px] border border-[#f5f5f5] px-[10px]",type:"text",placeholder:"Filter by category name"},null,32)]),l("div",null,[ee,l("input",{onInput:a[2]||(a[2]=t=>e.filterByBrandName(t)),class:"py-[10px] border border-[#f5f5f5] px-[10px]",type:"text",placeholder:"Filter by brand name"},null,32)])]),r(b,{columns:e.columns,"data-source":e.data,bordered:""},{image:d(({record:t})=>[l("img",{class:"w-[100px]",src:t.image,alt:"image"},null,8,te)]),name:d(({text:t})=>[l("a",null,V(t),1)]),category:d(({record:t})=>[l("span",null,V(t.category.name),1)]),brand:d(({record:t})=>[l("span",null,V(t.brand.name),1)]),operation:d(({record:t})=>[l("div",ae,[r(c,{class:"mr-[10px]",type:"primary",onClick:I=>e.editModal(t.id)},{default:d(()=>[oe]),_:2},1032,["onClick"]),r(c,{class:"!bg-[#ff4d4f]",type:"danger",onClick:I=>e.deleteHandler(t.id)},{default:d(()=>[re]),_:2},1032,["onClick"])])]),_:1},8,["columns","data-source"])]),r(P,{modelValue:e.visible,"onUpdate:modelValue":a[12]||(a[12]=t=>e.visible=t),width:"auto"},{default:d(()=>[r(B,{class:"product-form"},{default:d(()=>[r(S,{ref:"formRef",model:e.formState,rules:e.rules,"label-col":e.labelCol,"wrapper-col":e.wrapperCol},{default:d(()=>[r(i,{ref:"name",label:"Product name",name:"name"},{default:d(()=>[r(m,{value:e.formState.name,"onUpdate:value":a[3]||(a[3]=t=>e.formState.name=t)},null,8,["value"])]),_:1},512),r(i,{ref:"sku",label:"SKU",name:"sku"},{default:d(()=>[r(m,{value:e.formState.sku,"onUpdate:value":a[4]||(a[4]=t=>e.formState.sku=t)},null,8,["value"])]),_:1},512),r(i,{ref:"name",label:"Image",name:"image"},{default:d(()=>[l("div",le,[e.imageUrl?(x(),U("div",ne,[l("img",{class:"w-[150px]",src:e.imageUrl},null,8,de)])):C("",!0),e.imageUrl?C("",!0):(x(),U("label",se,ue)),l("input",{type:"file",name:"image",onChange:a[5]||(a[5]=(...t)=>e.onFileChange&&e.onFileChange(...t)),class:"opacity-0 absolute top-0 left-0 right-0 bottom-0 w-full h-full"},null,32)])]),_:1},512),r(i,{ref:"amount",label:"Amount",name:"amount"},{default:d(()=>[r(m,{value:e.formState.amount,"onUpdate:value":a[6]||(a[6]=t=>e.formState.amount=t)},null,8,["value"])]),_:1},512),r(i,{ref:"des",label:"Description",name:"des"},{default:d(()=>[r(s,{value:e.formState.des,"onUpdate:value":a[7]||(a[7]=t=>e.formState.des=t),"allow-clear":""},null,8,["value"])]),_:1},512),r(i,{class:"combobox_select",label:"Category",name:"category_id"},{default:d(()=>[r(v,{label:"Select category",modelValue:e.formState.category_id,"onUpdate:modelValue":a[8]||(a[8]=t=>e.formState.category_id=t),items:e.categories,"item-value":"id","item-title":"name"},null,8,["modelValue","items"])]),_:1}),r(i,{class:"combobox_select",label:"Brand",name:"brand_id"},{default:d(()=>[r(v,{label:"Select brand",modelValue:e.formState.brand_id,"onUpdate:modelValue":a[9]||(a[9]=t=>e.formState.brand_id=t),items:e.brands,"item-value":"id","item-title":"name","return-object":!0},null,8,["modelValue","items"])]),_:1}),r(i,{class:"combobox_select",label:"Product type",name:"product_type"},{default:d(()=>[r(v,{label:"Select product type",modelValue:e.formState.product_type,"onUpdate:modelValue":a[10]||(a[10]=t=>e.formState.product_type=t),items:["Sneakers","Streetwear"]},null,8,["modelValue"])]),_:1}),r(i,{"wrapper-col":{span:14,offset:4}},{default:d(()=>[e.pId?(x(),M(c,{key:0,class:"mr-[10px]",type:"primary",onClick:a[11]||(a[11]=t=>e.updateHandler(e.pId))},{default:d(()=>[ce]),_:1})):C("",!0),e.pId?C("",!0):(x(),M(c,{key:1,class:"mr-[10px]",type:"primary",onClick:e.onSubmit},{default:d(()=>[me]),_:1},8,["onClick"])),r(c,{class:"!bg-[#ff4d4f]",type:"danger",onClick:e.closeModal},{default:d(()=>[pe]),_:1},8,["onClick"])]),_:1})]),_:1},8,["model","rules","label-col","wrapper-col"])]),_:1})]),_:1},8,["modelValue"])])}const xe=F(K,[["render",fe]]);export{xe as default};