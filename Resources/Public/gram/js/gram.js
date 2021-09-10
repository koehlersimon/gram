class Gram{constructor(e){this.defaults={baseUrl:"http://localhost:5757/",galleryUrl:"http://localhost:5757/data/gallery-page-###PAGE###.json",notificationsUrl:"http://localhost:5757/data/notifications.json",notificationInterval:1e4},this.settings=e?Object.assign(this.defaults,e):this.defaults}loadData(e,t){let a=new XMLHttpRequest;a.open("GET",e,!0),a.setRequestHeader("Content-Type","application/json"),a.onreadystatechange=function(){if(4===this.readyState&&200===this.status){let e=this.responseText;t(e)}4===this.readyState&&404===this.status&&gram.notification("Error loading JSON data from: "+e)},a.setRequestHeader("X-Requested-With","XMLHttpRequest"),a.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),a.send()}loadGalleryItems(e,t,a){console.log(this.settings);var n=this,r=this.settings.galleryUrl.replace("###PAGE###",e);this.loadData(r,(function(e){JSON.parse(e).items.forEach(((e,a)=>{let r=n.galleryItem(e);t.appendChild(r)})),a()}))}showLoader(e){let t=document.getElementById(e),a=document.createElement("div");a.classList.add("spinner-border","text-light","m-auto"),a.innerHTML='<span class="sr-only">Loading...</span>',t.appendChild(a)}hideLoader(e){document.getElementById(e).innerHTML=""}pauseAllVideos(){let e=document.querySelectorAll("video");e&&e.forEach(((e,t)=>{e.pause()}))}buildCommentList(e,t){e.innerHTML="",t.length>0?t.forEach(((t,a)=>{let n=document.createElement("li"),r=document.createElement("strong"),s=document.createElement("p"),i=document.createElement("img");r.innerHTML=t.username,s.innerHTML=t.content,s.prepend(r),n.appendChild(i),n.appendChild(s),i.src=t.avatar,i.width=40,i.height=40,e.appendChild(n)})):e.innerHTML='<li class="alert alert-info m-4">No comments yet. Be the first one to write something!</li>'}resetModal(e){e.querySelector(".username").innerHTML="",e.querySelector(".location").innerHTML="",e.querySelector("textarea").value="",gram.textAreaAdjust(e.querySelector("textarea")),e.querySelector("ul.comments").innerHTML=""}textAreaAdjust(e){e.scrollHeight<300&&(e.style.height="1px",e.style.height=0+e.scrollHeight+"px")}galleryItem(e){let t=document.createElement("div");return t.classList.add("col"),t.innerHTML='<a href="#" data-bs-toggle="modal" data-bs-target="#modal-post" data-bs-postid="'+e.id+'"><div><img src="'+e.thumbnail+'" alt="thumbnail" class="w-100 h-100"></div><div class="overlay"><i class="fa fa-heart"></i> '+e.likecount+' <i class="fa fa-comment"></i> '+e.commentcount+"</div></a>",t}notification(e){var t=document.getElementById("liveToast"),a=new bootstrap.Toast(t);t.querySelector(".toast-body").innerHTML=e,a.show()}initStyles(){let e=document.getElementById("styles"),t=e.getAttribute("data-light"),a=e.getAttribute("data-dark");"light"===gram.getCookie("currentstyle")?e.href=t:"dark"===gram.getCookie("currentstyle")&&(e.href=a)}toggleStyles(){let e=document.getElementById("styles"),t=e.getAttribute("data-light"),a=e.getAttribute("data-dark");"light"===gram.getCookie("currentstyle")?(e.href=a,gram.setCookie("currentstyle","dark",10)):(gram.getCookie("currentstyle"),e.href=t,gram.setCookie("currentstyle","light",10))}setCookie(e,t,a){const n=new Date;n.setTime(n.getTime()+24*a*60*60*1e3);let r="expires="+n.toUTCString();document.cookie=e+"="+t+";"+r+";path=/"}getCookie(e){let t=e+"=",a=document.cookie.split(";");for(let e=0;e<a.length;e++){let n=a[e];for(;" "==n.charAt(0);)n=n.substring(1);if(0==n.indexOf(t))return n.substring(t.length,n.length)}return""}updateNotifications(){const e=document.querySelector(".dropdown-menu-likes");e&&(e.innerHTML="",gram.loadData(this.settings.notificationsUrl,(function(t){JSON.parse(t).notifications.forEach(((t,a)=>{var n=document.createElement("li");n.innerHTML='<img src="'+t.avatar+'" class="avatar" width="24" height="24" alt="'+t.username+'"><div class="px-2"><a href="profile.html"><strong>'+t.username+"</strong></a> "+t.message+' <span class="text-muted">'+t.time+'</span></div><img src="'+t.avatar+'" class="ms-auto" width="40" height="40" alt="'+t.username+'">',e.appendChild(n)}))})))}}