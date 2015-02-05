 /**
 * Name: notification
 * Purpose: Display notification.
 * @params: name - string : Name of user who submits expense
 * @params: message - string : Type of notification
*  @params: time - string : Time
 */
function notification(name, message, time){
    $.notify({
        time : time,
        name : name,
        message : message
    }, {
        style: 'glide',
        globalPosition: 'bottom right',
        hideDuration: 700,
        autoHideDelay: 20000,
        gap:10
    });
}