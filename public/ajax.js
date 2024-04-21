function like(arg){
    console.log("abc");
    console.log(arg);
    $.ajax({
        url: '/like/post',
        type: "post",
        data: ({post_id: arg}),
        dataType: "json",
        success: function (data) {
          console.log(data);
          console.log("Like");
          document.getElementById("likeb").classList.add("d-none");
          document.getElementById("unlikeb").classList.remove("d-none");
          let n = document.getElementById("n-2").innerText;
          n = parseInt(n) + 1;
          document.getElementById("n-2").innerText = n;
          document.getElementById("n-1").innerText = n;
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function unlike(arg){
    console.log("abc");
    console.log(arg);
    $.ajax({
        url: '/unlike/post',
        type: "post",
        data: ({post_id: arg}),
        dataType: "json",
        success: function (data) {
          console.log(data);
          console.log("Unlike");
          document.getElementById("unlikeb").classList.add("d-none");
          document.getElementById("likeb").classList.remove("d-none");
          let n = document.getElementById("n-1").innerText;
          n = parseInt(n) - 1;
          document.getElementById("n-2").innerText = n;
          document.getElementById("n-1").innerText = n;
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function follow(arg){
    console.log("abc");
    console.log(arg);
    $.ajax({
        url: '/follow/user',
        type: "post",
        data: ({user_id: arg}),
        dataType: "json",
        success: function (data) {
          console.log(data);
          console.log("Followed");
          document.getElementById("fb").classList.add("d-none");
          document.getElementById("ufb").classList.remove("d-none");
          let n = document.getElementById("count").innerText;
          n = parseInt(n) + 1;
          document.getElementById("count").innerText = n;
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function unfollow(arg){
    console.log("abc");
    console.log(arg);
    $.ajax({
        url: '/unfollow/user',
        type: "post",
        data: ({user_id: arg}),
        dataType: "json",
        success: function (data) {
          console.log(data);
          console.log("Followed");
          document.getElementById("ufb").classList.add("d-none");
          document.getElementById("fb").classList.remove("d-none");
          let n = document.getElementById("count").innerText;
          n = parseInt(n) - 1;
          document.getElementById("count").innerText = n;
        },
        error: function (data) {
            console.log(data);
        }
    });
}