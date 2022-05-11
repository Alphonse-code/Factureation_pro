$(document).ready(function (e) {
  e.preventDefault;
  var societe = document.getElementById('block-societe');
  var client = document.getElementById('block-client');
  $("#nature-client").on('change', function () {
    if (this.value == "1") {
      societe.hidden = false;
      client.hidden = true;
    }
    if (this.value == "0") {
      societe.hidden = true;
      client.hidden = false;
    }
  });
  // reference v1
  $("#modif_prefV1").on('click', function () {
    $('#prefixeV1').attr("disabled", false);
  });
  $("#prefixeV1").on('change', function () {
    $('#prefixeV1').attr("disabled", true);
    var prefixe = $(this).val();
    var num = document.getElementById("numV1").value;
    document.getElementById("ref").textContent = prefixe + "-" + num;
  });
  // reference edit facture
  $("#modif_prefE").on('click', function () {
    $('#prefixeE').attr("disabled", false);
  });
  // reference v2
  $("#modif_prefV2").on('click', function () {
    $('#prefixeV2').attr("disabled", false);
  });
  $("#prefixeV2").on('change', function () {
    $('#prefixeV2').attr("disabled", true);
    var prefixe = $(this).val();
    var num = document.getElementById("numV2").value;
    document.getElementById("refV2").textContent = prefixe + "-" + num;
  });
  // annuler la creation de facture
  $("#annulerV1").click(function () {
    $("#add_ligne")[0].reset();
    document.getElementById("tht_txt").textContent = "0";
    document.getElementById("mt-tva").textContent = "0";
    document.getElementById("remise_globale").textContent = "0";
    document.getElementById("total_ttc").textContent = "0"
  });
});



/**
  * view item invoice
  */
function viewItemInvoice() {
  var ref = document.getElementById("item").getAttribute("data-id");
  var data = {
    id: ref,
  };
  var datapath = document.getElementById("item").getAttribute("data-path");
  console.log(datapath);
  $.ajax({
    type: "GET",
    url: datapath,
    dataType: "json",
    data: data,
    success: function (data) {
      console.log(data);
      var len = data.length;
      $("#table_facture tbody").empty();
      var myTableBody = $("#table_facture tbody");
      if (len > 0) {
        $.each(data, function (key, val) {
          $("#table_facture > tbody").append(

          );
        });
      } else {

      }
    },
    error: function (response) {
      console.log(response);
    },
  });
}

// supprimer client

$("#checkAllClient").click(function () {
  $(".checkclient").prop('checked', $(this).prop('checked'));
});
$("#supprimerClient").click(function (e) {
  e.preventDefault();
  var allids = [];
  $(":checkbox:checked").each(function () {
    allids.push($(this).val());
  });
  if (allids.length > 0) {
    var idpth = document.getElementById("supprimerClient");
    var path = idpth.getAttribute("data-path");
    $.ajax({
      url: path,
      type: "DELETE",
      data: { 'id': allids },
      success: function (result) {
        console.log(result);
        $('#message').html('');
        // getClients()
        setTimeout(window.location.reload.bind(window.location), 200);
        if (result.status == 'success') {
          $('#message').append(
            '<div class="alert alert-success alert-dismissable">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            result.message +
            '</div>'
          );
          setTimeout(function () {
            $("#message").remove();
          }, 3000);
        } else {
          $('#message').append(
            '<div class="alert alert-danger alert-dismissable">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            result.message +
            '</div>'
          );
          setTimeout(function () {
            $("#message").remove();
          }, 3000);
        }
      },
      error: function (response) {
        console.log(response);
      },

    })
  } else {
    alert("veuillez choisir un client!");
  }
})
//modification client
$("#editClientBtn").click(function (e) {
  e.preventDefault();
  var allids = [];
  $(":checkbox:checked").each(function () {
    allids.push($(this).val());
  });
  if (allids.length > 0 && allids.length < 2) {
    $("#editClient").modal('show');
    let edit = document.getElementById("editClientBtn");
    var path = edit.getAttribute("data-path");
    $.ajax({
      type: "get",
      url: path,
      data: { id: allids },
      dataType: "json",
      success: function (val) {
        console.log(val);
        document.getElementById("nomE").value = val.nomClient;
        document.getElementById("prenomE").value = val.prenomClient;
        document.getElementById("emailE").value = val.email;
        document.getElementById("numRueE").value = val.numRueClient;
        document.getElementById("nomRueE").value = val.nomRueClient;
        document.getElementById("codePostalE").value = val.codePostalClient;
        document.getElementById("villeE").value = val.villeClient;
        document.getElementById("fixeE").value = val.fixe;
        document.getElementById("paysE").value = val.paysClient;
        document.getElementById("portable1E").value = val.tel;
        document.getElementById("portable2E").value = val.tel2;
        document.getElementById("conditionE").value = val.coditionDePaiement;
        document.getElementById("nomSocieteE").value = val.nomClient;
        document.getElementById("numSerieE").value = val.numeroDeSerieClient;
        document.getElementById("titreSocieteE").value = val.titreEntrepriseClient;
        document.getElementById("adresseE").value = val.adresseFactureClient;
        document.getElementById("idClient").value = val.id;
      },
      error: function (response) {
        console.log(response);
      },
    });
  } else {
    alert("veuillez choisir un client!");
  }
})
// action delete produit
$("#checkAllProduit").click(function () {
  $(".checkproduit").prop('checked', $(this).prop('checked'));
});
$("#supprimerProduit").click(function (e) {
  e.preventDefault();
  var allids = [];
  $(":checkbox:checked").each(function () {
    allids.push($(this).val());
  });
  console.log(allids);
  var idpth = document.getElementById("supprimerProduit");
  var path = idpth.getAttribute("data-path");
  $.ajax({
    url: path,
    type: "DELETE",
    data: { 'id': allids },
    success: function (result) {
      console.log(result);
      getProduit();
      $('#message').html('');
      if (result.status == 'success') {
        $('#message').append(
          '<div class="alert alert-success alert-dismissable">' +
          '<button type="button" class="close" data-dismiss="alert">' +
          '<span aria-hidden="true">&times;</span>' +
          '<span class="sr-only">Close</span>' +
          '</button>' +
          result.message +
          '</div>'
        );
        setTimeout(function () {
          $("#message").remove();
        }, 2000);
      } else {
        $('#message').append(
          '<div class="alert alert-danger alert-dismissable">' +
          '<button type="button" class="close" data-dismiss="alert">' +
          '<span aria-hidden="true">&times;</span>' +
          '<span class="sr-only">Close</span>' +
          '</button>' +
          result.message +
          '</div>'
        );
        setTimeout(function () {
          $("#message").remove();
        }, 3000);
      }
    },
    error: function (response) {
      console.log(response);
    },
  })

})

//modification produit
$("#editProduitBtn").click(function (e) {
  e.preventDefault();
  var allids = [];
  $(":checkbox:checked").each(function () {
    allids.push($(this).val());
  });
  $("#editProduit").modal('show');
  let edit = document.getElementById("editProduitBtn");
  var path = edit.getAttribute("data-path");
  console.log(path);
  $.ajax({
    type: "get",
    url: path,
    data: { id: allids },
    dataType: "json",
    success: function (val) {
      document.getElementById("nomProduitE").value = val.nomProduit;
      document.getElementById("commentE").value = val.comment;
      document.getElementById("prixbaseE").value = val.prixBase;
      document.getElementById("prixHTE").value = val.prixUHT;
      document.getElementById("prixTTCE").value = val.prixUTTC;
      document.getElementById("tvaE").value = val.tva;
      document.getElementById("id").value = val.id;
    },
    error: function (response) {
      console.log(response);
    },
  });

})

// edit client action
function editActionClient() {
  var nom = document.getElementById("nomE").value;
  var prenom = document.getElementById("prenomE").value;
  var email = document.getElementById("emailE").value;
  var numRue = document.getElementById("numRueE").value;
  var nomRue = document.getElementById("nomRueE").value;
  var pays = document.getElementById("paysE").value;
  var codePostal = document.getElementById("codePostalE").value;
  var ville = document.getElementById("villeE").value;
  var fixe = document.getElementById("fixeE").value;
  var portable1 = document.getElementById("portable1E").value;
  var portable2 = document.getElementById("portable2E").value;
  var condition = document.getElementById("conditionE").value;
  var nomSociete = document.getElementById("nomSocieteE").value;
  var numSerie = document.getElementById("numSerieE").value;
  var titreSociete = document.getElementById("titreSocieteE").value;
  var adresse = document.getElementById("adresseE").value;
  var id = document.getElementById("idClient").value;
  var data = {
    nom: nom, prenom: prenom, email: email, numRue: numRue, pays: pays, nomRue: nomRue, codePostal: codePostal,
    ville: ville, fixe: fixe, portable1: portable1, adresse: adresse, portable2: portable2, condition: condition,
    nomSociete: nomSociete, id: id, numSerie: numSerie, titreSociete: titreSociete
  }
  var editbtn = document.getElementById("btn-clientEdit");
  let url = editbtn.getAttribute("data-path");
  editbtn.textContent = "En cours..."
  $.ajax({
    type: "post",
    url: url,
    dataType: "json",
    data: data,
    success: function (result) {
      $("#editClient").modal('hide');
      //getClients();
      setTimeout(window.location.reload.bind(window.location), 250);
      $('#message').html('');
      if (result.status == 'success') {
        $('#message').append(
          '<div class="alert alert-success alert-dismissable">' +
          '<button type="button" class="close" data-dismiss="alert">' +
          '<span aria-hidden="true">&times;</span>' +
          '<span class="sr-only">Close</span>' +
          '</button>' +
          result.message +
          '</div>'
        );
        setTimeout(function () {
          $("#message").remove();
        }, 2000);
      } else {
        $('#message').append(
          '<div class="alert alert-danger alert-dismissable">' +
          '<button type="button" class="close" data-dismiss="alert">' +
          '<span aria-hidden="true">&times;</span>' +
          '<span class="sr-only">Close</span>' +
          '</button>' +
          result.message +
          '</div>'
        );
        setTimeout(function () {
          $("#message").remove();
        }, 3000);
      }
    },
    error: function (response) {
      console.log(response);
    },
  });
}

