const setCookie = (cookieName, cookieValue, cookieExDays) => {
    var d = new Date();
    d.setTime(d.getTime() + (cookieExDays*24*60*60*1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cookieName + "=" + cookieValue + "; " + expires + "; path=/";
}

const getCookie = (cookieName) => {
    var name = cookieName + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

const deleteCookie = (cookieName) => {
  document.cookie = cookieName+"=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
}