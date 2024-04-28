const t=$("#btn-load-more-news");function f({title:o="",slug:n="",image:d=""}){let e=window.location.href;return`<div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card">
            <a href="${e}${n}" class="card-text" title="${o}">
                <img src="${d}" class="card-img-top" alt="${o}">
            </a>
            <div class="card-body">
                <a href="${e}${n}" class="card-text" title="${o}"><strong>${o}</strong></a>
            </div>
        </div>
    </div>`}t.on("click",function(o){const n=t.data("state"),d=t.closest(".load-more-news").siblings(".news-list");if(n=="loading")return;const e=t.html(),u=t.data("page")||1,p=new URLSearchParams(window.location.search),l={page:u+1};p.forEach((a,c)=>{l[c]=a}),console.log("({}).: ","https://hdtinchap.com"),$.ajax({type:"GET",url:"https://hdtinchap.com/api/new-load-more",data:l,beforeSend:function(){h()},success:function(a){var c,i,g;if(r(),!a.status){console.log(a);return}(c=a.data)!=null&&c.data&&a.data.data.forEach(s=>{let m=f({title:s.title,slug:s.slug,image:s.image});d.append(m)}),t.data("page",a.data.current_page),((i=a.data)==null?void 0:i.current_page)==((g=a.data)==null?void 0:g.last_page)&&t.hide()},error:function(a){r(),console.log(a)}});function h(){t.html("Đang tải..."),t.data("state","loading")}function r(){t.html(e),t.data("state","done")}o.preventDefault()});
