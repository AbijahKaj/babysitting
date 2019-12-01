/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(() => {
    $("#appointment").submit((e) => {
        e.preventDefault()
        var data = $("#appointment").serialize()
        $.ajax({
            method: "POST",
            url: "ajax.php?action=add-appointment",
            data: data,
            cache: false,
            dataType: 'json'
        }).done((data) => {
            if (data.status == "1") {
                $("#appointment")[0].reset();
                location.reload();
            }
        })
    })
    
    $("#child-form").submit((e) => {
        e.preventDefault()
        var data = $("#child-form").serialize()
        $.ajax({
            method: "POST",
            url: "ajax.php?action=add-child",
            data: data,
            cache: false,
            dataType: 'json'
        }).done((data) => {
            if (data.status == "1") {
                $("#child-form")[0].reset();
                location.reload();
            }
        })
    })
})