/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(() => {
    $("#signup").submit((e) => {
        e.preventDefault()
        var data = $("#signup").serialize()
        $.ajax({
            method: "POST",
            url: "ajax.php?action=signup",
            data: data,
            cache: false,
            dataType: 'json'
        }).done((data) => {
            if(data.status == "1"){
                document.location = "dashboard.php"
                return true
            }
        })
    })
    $("#signin").submit((e) => {
        e.preventDefault()
        var data = $("#signin").serialize()
        $.ajax({
            method: "POST",
            url: "ajax.php?action=signin",
            data: data,
            cache: false,
            dataType: 'json'
        }).done((data) => {
            if(data.status == "1"){
                document.location = "dashboard.php"
                return true
            }
        })
        
    })
})