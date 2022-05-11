
$(document).ready(function (e) {
    var societe = document.getElementById('societe');
    var client = document.getElementById('client-');
    $("#client-type").on('change', function () {
        if (this.value == "1") {
            societe.hidden = false;
            client.hidden = true;
        }
        if (this.value == "0") {
            societe.hidden = true;
            client.hidden = false;
        }
    });
    var entreprise = document.getElementById('entreprise');
    var particuliere = document.getElementById('particuliere');
    $("#type_client").on('change', function () {
        if (this.value == "1") {
            entreprise.hidden = false;
            particuliere.hidden = true;
        }
        if (this.value == "0") {
            entreprise.hidden = true;
            particuliere.hidden = false;
        }
    });
    // invoice line
    $("#add").click(function (e) {
        // Get last id
        var lastname_id = $(".tr_input input[type=text]:nth-child(1)")
            .last()
            .attr("id");
        var split_id = lastname_id.split("_");
        // New index
        var index = Number(split_id[1]) + 1;
        console.log(index);
        var td =
            "<tr class='tr_input'> <td><input list='listProd' type='text' name='ref[]' contenteditable='true'  class='form-control form-control-sm productname item_name' id='ref_" +
            index +
            "' > <datalist id='listProd'> <option value=''></option> </datalist></td><td><input type='text' name='produit[]'  class='form-control form-control-sm produit' id='produit_" +
            index +
            "' ></td><td><input type='number' name='qt[]'  class='form-control form-control-sm qt' id='qt_" +
            index +
            "' ></td><td> <div class='input-group'> <span class='input-group-text'>€</span> <input type='text' name='prixUnit[]' id='prixUnit_" +
            index + "' class='form-control form-control-sm  prixUnit' aria-label='Amount (to the nearest dollar)'>  <span class='input-group-text'>.00</span> </div></td> <td><input type='number' name='remise[]' value='0' class='form-control form-control-sm remise' id='remise_" +
            index +
            "' ></td> <td><input type='text' name='tva[]'  class='form-control form-control-sm tva' id='tva_" +
            index +
            "' ></td><td><input type='text' name='totalHT[]'  class='form-control form-control-sm totalHT' id='totalHT_" +
            index +
            "' ></td><td><input type='button' value='X' class='btn btn-danger btn-sm btnX'></td></tr>";
        var html =
            '<div class="row g-8"> <div class="col-2"><input type="text"  class="form-control form-control-sm" id="ref" ></div><div class="col-3"><input type="text"  class="form-control form-control-sm" id="designation" ></div><div class="col-1"><input type="text" class="form-control form-control-sm" id="qt" ></div><div class="col-1"><input type="text"  class="form-control form-control-sm" id="staticEmail2"></div><div class="col-2"><input type="text"  class="form-control form-control-sm" id="staticEmail2"></div><div class="col-1"><input type="password" class="form-control form-control-sm" id="inputPassword2" ></div><div class="col-1"><input type="password" class="form-control form-control-sm" id="inputPassword2"></div><div class="col-1"><i class="fas fa-trash text-danger" id="remove"></i></div></div>';
        $("#my-line").append(td);
    });

    $("#my-line").on("click", ".btnX", function (event) {
        $(this).closest("tr").remove();
        // Get last id
        var lastname_id = $(".tr_input input[type=text]:nth-child(1)")
            .last()
            .attr("id");
        var split_id = lastname_id.split("_");
        // New index
        var index = Number(split_id[1])
        changeTousTotal();
    });
});
$(document).ready(function (e) {
    $("#addE").click(function (e) {
        // Get last id
        var lastname_id = $(".tr_input input[type=text]:nth-child(1)")
            .last()
            .attr("id");
        var split_id = lastname_id.split("_");
        // New index
        var index = Number(split_id[1]) + 1;
        console.log(index);
        var td =
            "<tr class='tr_input'> <td><input list='listProd' type='text' name='refE[]' contenteditable='true'  class='form-control form-control-sm productnameE item_name' id='refE_" +
            index +
            "' > <datalist id='listProd'> <option value=''></option> </datalist></td><td><input type='text' name='produitE[]'  class='form-control form-control-sm produit' id='produitE_" +
            index +
            "' ></td><td><input type='number' name='qtE[]'  class='form-control form-control-sm qt' id='qtE_" +
            index +
            "' ></td><td> <div class='input-group'> <span class='input-group-text'>€</span> <input type='text' name='prixUnitE[]' id='prixUnitE_" +
            index + "' class='form-control form-control-sm  prixUnit' aria-label='Amount (to the nearest dollar)'>  <span class='input-group-text'>.00</span> </div></td> <td><input type='number' name='remiseE[]' value='0' class='form-control form-control-sm remise' id='remiseE_" +
            index +
            "' ></td> <td><input type='text' name='tvaE[]'  class='form-control form-control-sm tva' id='tvaE_" +
            index +
            "' ></td><td><input type='text' name='totalHTE[]'  class='form-control form-control-sm totalHT' id='totalHTE_" +
            index +
            "' ></td><td><input type='button' value='X' class='btn btn-danger btn-sm btnX'></td></tr>";
        var html =
            '<div class="row g-8"> <div class="col-2"><input type="text"  class="form-control form-control-sm" id="ref" ></div><div class="col-3"><input type="text"  class="form-control form-control-sm" id="designation" ></div><div class="col-1"><input type="text" class="form-control form-control-sm" id="qt" ></div><div class="col-1"><input type="text"  class="form-control form-control-sm" id="staticEmail2"></div><div class="col-2"><input type="text"  class="form-control form-control-sm" id="staticEmail2"></div><div class="col-1"><input type="password" class="form-control form-control-sm" id="inputPassword2" ></div><div class="col-1"><input type="password" class="form-control form-control-sm" id="inputPassword2"></div><div class="col-1"><i class="fas fa-trash text-danger" id="remove"></i></div></div>';
        $("#my-line").append(td);
    });
    $("#my-line").on("click", ".btnX", function (event) {
        $(this).closest("tr").remove();
        changeTousTotal();
    });
});
function changeTousTotal() {
    document.getElementById("tht_txtE").textContent = "0";
    document.getElementById("mt-tvaE").textContent = "0";
    document.getElementById("remise_globaleE").textContent = "0";
    document.getElementById("total_ttcE").textContent = "0"
}
/**
 * recupération d'un produit pour edit facture
 */
$(document).on("keydown", ".productnameE", function () {
    var id = this.id;
    var res = id.split("_");
    var index = res[1];
    var produit = $("#refE_" + index).val();
    var data = { produit: produit };
    console.log("eto" + produit);
    let url = "http://invoice.fr/produit/lists";
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (data) {
            console.log(data);
            $("#listProd").empty();
            for (i = 0; i < data.length; i++) {
                $("#listProd").append(
                    '<option id="prod-option" data-id="' +
                    data[i].id +
                    '"  value="' +
                    data[i].ref +
                    '">' +
                    data[i].nomProduit +
                    " </br> " +
                    data[i].prixUTTC +
                    "</option>",
                );
                if (data.length == "0") {
                    $("#listProd").append(
                        "</option>",
                        '<option id="prod-new" value="' +
                        "Nouveau " +
                        '">' +
                        "Nouveau " +
                        " </br> " +
                        "Nouveau " +
                        "</option>"
                    );
                }
            }
            if (data.length > 0) {
                var listproduit = document.getElementById("refE_" + index).value;
                if (listproduit) {
                    var produit_id = document.querySelector(
                        "#listProd" + " option[value='" + listproduit + "']"
                    ).dataset.id;
                    console.log(produit_id);
                    var data = {
                        id: produit_id,
                    };
                }
                //let url = "http://invoice.fr/produit/infos";
                var url = Routing.generate('infos_produit');
                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "json",
                    data: data,
                    success: function (data) {
                        $.each(data, function (key, val) {
                            console.log("VAL" + val.tva);
                            if (val.prixBase == 1) {
                                document.getElementById("prixUnitE_" + index).value = val.prixUTTC;
                            } else {
                                document.getElementById("prixUnitE_" + index).value = val.prixUHT;
                            }
                            document.getElementById("tvaE_" + index).value = val.tva;
                            document.getElementById("produitE_" + index).value = val.nomProduit;
                            $(document.getElementById("qtE_" + index)).on('change', function () {
                                $qt_value = $(this).val();
                                var tht =
                                    $qt_value *
                                    document.getElementById("prixUnitE_" + index).value;
                                document.getElementById("totalHTE_" + index).value = tht;
                                var item_tht = [];
                                $(".totalHT").each(function () {
                                    var maTHT = $(this).val();
                                    var pTHT = parseInt(maTHT);
                                    item_tht.push(pTHT);
                                });
                                var total_HT = _.sum(item_tht);
                                document.getElementById("tht_txtE").textContent = total_HT;
                                var total_ttc = document.getElementById("total_ttcE");
                                total_ttc.textContent = total_HT;
                                // IF tva
                                var item_tva = [];
                                var tva_ligne = document.getElementById("tvaE_" + index).value;
                                if (tva_ligne > 0) {
                                    var total_tva_ligne = parseInt((tht * tva_ligne) / 100)
                                    $(".tva").each(function () {
                                        item_tva.push(total_tva_ligne);
                                    });
                                    var montant_tva = _.sum(item_tva);
                                    document.getElementById("mt-tvaE").textContent = montant_tva;
                                    if (montant_tva) {
                                        var total_ttc = document.getElementById("total_ttcE");
                                        total_ttc.textContent = "";
                                        var net_a_payer = parseInt(total_HT + montant_tva);
                                        total_ttc.textContent = net_a_payer;
                                    }
                                    console.log("total" + net_a_payer);
                                }
                            });
                            // calcule de remise
                            $(document.getElementById("remiseE_" + index)).on('change', function () {
                                var remise_value = $(this).val();
                                var total_ht = document.getElementById("totalHTE_" + index).value;
                                var ligne_remise = parseInt((total_ht * remise_value) / 100);
                                var lignes_remise = [];
                                $(".remise").each(function () {
                                    lignes_remise.push(ligne_remise);
                                });
                                console.log(lignes_remise);
                                var sum_ligne_remise = _.sum(lignes_remise);
                                //console.log(sum_ligne_remise);
                                var total_ligne_ht = document.getElementById("tht_txtE").textContent;
                                //get last total à payer
                                var last_total_a_payer = document.getElementById("total_ttcE").textContent;
                                console.log("last" + last_total_a_payer);
                                var total_a_payer = parseInt(last_total_a_payer) - parseInt(sum_ligne_remise);
                                var id_remise_globale = document.getElementById("remise_globaleE");
                                var total_ttc = document.getElementById("total_ttcE");
                                id_remise_globale.textContent = sum_ligne_remise;
                                total_ttc.textContent = total_a_payer;
                            });
                            if (Number(document.getElementById("qtE_" + index).value) != NaN) {
                                var tht =
                                    document.getElementById("qtE_" + index).value *
                                    document.getElementById("prixUnitE_" + index).value;
                                document.getElementById("totalHTE_" + index).value = tht;
                            }
                        });
                    },
                    error: function (response) {
                        console.log(response);
                    },
                });
            } else {
                console.log("product not found");
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
});
// get client to select
function getClients() {
    var nom = $("#nomClient").val();
    var data = { nom: nom };
    let url = Routing.generate('client_clients');
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (data) {
            $("#infos").empty();
            for (i = 0; i < data.length; i++) {
                $("#infos").append(
                    '<option data-id="' +
                    data[i].id +
                    '" value="' +
                    data[i].nomClient +
                    '">' +
                    data[i].adresseFactureClient +
                    " </br> " +
                    data[i].tel +
                    "</option>"
                );
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
}

function completeCondition() {
    var client = document.getElementById("nomClient").value;
    var client_id = document.querySelector(
        "#infos" + " option[value='" + client + "']"
    ).dataset.id;
    console.log(client_id);
    var data = {
        id: client_id,
    };
    let url = Routing.generate("client_facture");
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (data) {
            $("#condition").empty();
            $.each(data, function (key, val) {
                document.getElementById("condition").value = val.coditionDePaiement;
                $("#condition").append(
                    '<option data-id="' +
                    val.id +
                    '" value="' +
                    val.coditionDePaiement +
                    '">' +
                    val.coditionDePaiement + "Jours" +
                    "</option>");
            });
        },
        error: function (response) {
            console.log(response);
        },
    });
}
function completeEcheance() {
    const date = document.getElementById("date").value;
    const condition = document.getElementById("condition").value;
    const jour = new Date(date);
    const jours = jour.getDate();
    const e = new Date(new Date().setDate(parseInt(jour.getDate()) + parseInt(condition)));
    // formaté le date 
    function formatDate(e) {
        var d = new Date(e),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();
        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;
        return [year, month, day].join('-');
    }
    var dateString = formatDate(e);
    document.getElementById("echeance").value = dateString;
}
function completeEcheanceV1() {
    const date = document.getElementById("dateV1").value;
    const condition = document.getElementById("conditionV1").value;
    const jour = new Date(date);
    const jours = jour.getDate();
    const e = new Date(new Date().setDate(parseInt(jour.getDate()) + parseInt(condition)));
    // formaté le date 
    function formatDate(e) {
        var d = new Date(e),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
    var dateString = formatDate(e);
    document.getElementById("echeanceV1").value = dateString;
}
/**
 * recupération d'un produit
 */
$(document).on("keydown", ".productname", function () {
    var id = this.id;
    var res = id.split("_");
    var index = res[1];
    var produit = $("#ref_" + index).val();
    var data = { produit: produit };
    console.log("eto" + produit);
    let url = Routing.generate("produits");
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (data) {
            console.log(data.length);
            $("#listProd").empty();
            for (i = 0; i < data.length; i++) {
                $("#listProd").append(
                    '<option id="prod-option" data-id="' +
                    data[i].id +
                    '"  value="' +
                    data[i].ref +
                    '">' +
                    data[i].nomProduit +
                    " </br> " +
                    data[i].prixUTTC +
                    "</option>",
                );
            }
            if (data.length === 1) {
                console.log(data.length);
                var listproduit = document.getElementById("ref_" + index).value;
                if (listproduit) {
                    var produit_id = document.querySelector(
                        "#listProd" + " option[value='" + listproduit + "']"
                    ).dataset.id;
                    var data = {
                        id: produit_id,
                    };
                }
                console.log(data);
                let url = Routing.generate("infos_produit");
                $.ajax({
                    type: "post",
                    url: url,
                    dataType: "json",
                    data: data,
                    success: function (data) {
                        console.log(data);
                        $.each(data, function (key, val) {
                            console.log(val.tva);
                            if (val.prixBase == "1") {
                                document.getElementById("prixUnit_" + index).value = val.prixUTTC;
                                document.getElementById("tva_" + index).value = "0";
                            } else {
                                document.getElementById("prixUnit_" + index).value = val.prixUHT;
                                document.getElementById("tva_" + index).value = val.tva;
                            }

                            document.getElementById("produit_" + index).value = val.nomProduit;

                            $(document.getElementById("qt_" + index)).on('change', function () {
                                $qt_value = $(this).val();
                                var tht =
                                    $qt_value *
                                    document.getElementById("prixUnit_" + index).value;
                                document.getElementById("totalHT_" + index).value = tht;
                                var item_tht = [];
                                $(".totalHT").each(function () {
                                    var maTHT = $(this).val();
                                    var pTHT = parseInt(maTHT);
                                    item_tht.push(pTHT);
                                });
                                var total_HT = _.sum(item_tht);
                                document.getElementById("tht_txt").textContent = total_HT;
                                var total_ttc = document.getElementById("total_ttc");
                                total_ttc.textContent = total_HT;
                                // IF tva
                                var item_tva = [];
                                var tva_ligne = document.getElementById("tva_" + index).value;
                                if (tva_ligne > 0) {
                                    var total_tva_ligne = parseInt((tht * tva_ligne) / 100)
                                    $(".tva").each(function () {
                                        item_tva.push(total_tva_ligne);
                                    });
                                    var montant_tva = _.sum(item_tva);
                                    document.getElementById("mt-tva").textContent = montant_tva;
                                    if (montant_tva) {
                                        var total_ttc = document.getElementById("total_ttc");
                                        total_ttc.textContent = "";
                                        var net_a_payer = parseInt(total_HT + montant_tva);
                                        total_ttc.textContent = net_a_payer;
                                    }
                                    console.log("total" + net_a_payer);
                                }

                            });

                            // calcule de remise
                            $(document.getElementById("remise_" + index)).on('change', function () {
                                var remise_value = $(this).val();
                                var total_ht = document.getElementById("totalHT_" + index).value;
                                var ligne_remise = parseInt((total_ht * remise_value) / 100);
                                var lignes_remise = [];
                                $(".remise").each(function () {
                                    lignes_remise.push(ligne_remise);
                                });
                                console.log(lignes_remise);
                                var sum_ligne_remise = _.sum(lignes_remise);
                                //console.log(sum_ligne_remise);
                                var total_ligne_ht = document.getElementById("tht_txt").textContent;
                                //get last total à payer
                                var last_total_a_payer = document.getElementById("total_ttc").textContent;
                                console.log("last" + last_total_a_payer);
                                var total_a_payer = parseInt(last_total_a_payer) - parseInt(sum_ligne_remise);
                                var id_remise_globale = document.getElementById("remise_globale");
                                var total_ttc = document.getElementById("total_ttc");
                                id_remise_globale.textContent = sum_ligne_remise;
                                total_ttc.textContent = total_a_payer;
                            });
                            if (Number(document.getElementById("qt_" + index).value) != NaN) {
                                var tht =
                                    document.getElementById("qt_" + index).value *
                                    document.getElementById("prixUnit_" + index).value;
                                document.getElementById("totalHT_" + index).value = tht;
                            }
                        });
                    },
                    error: function (response) {
                        console.log(response);
                    },
                });
            } else {
                console.log("product not found");
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
});



/** ******************** produit ************************* */


// Control champ 
$("#prixHT").keyup(function () {
    var prixHT = document.getElementById("prixHT").value;

    if (isNaN(prixHT)) {
        var p = prixHT.substring(0, prixHT.length - 1);
        document.getElementById("prixHT").value = p;
    }
});


$("#prixTTC").keyup(function () {
    var prixTTC = document.getElementById("prixTTC").value;

    if (isNaN(prixTTC)) {
        var p = prixTTC.substring(0, prixTTC.length - 1);
        document.getElementById("prixTTC").value = p;
    }
});




$("#tva").keyup(function () {
    var tva = document.getElementById("tva").value;

    if (isNaN(tva)) {
        var p = tva.substring(0, tva.length - 1);
        document.getElementById("tva").value = p;
    }
});



/**
 * ajout produit
 */
function ajoutProduit() {
    var btn_produit = document.getElementById("btn-produit");
    var nomProduit = document.getElementById("nomProduit").value;
    var comment = document.getElementById("comment").value;
    var prixbase = document.getElementById("prixbase").value;
    var tva = document.getElementById("tva").value;
    var prixHT = document.getElementById("prixHT").value;
    var prixTTC = document.getElementById("prixTTC").value;
    var data = {
        nomProduit: nomProduit, comment: comment, prixbase: prixbase, prixHT: prixHT, tva: tva, prixTTC: prixTTC
    }


    console.log(data);


    let url = Routing.generate("ajout_produit");
    if (nomProduit != "" && tva != "" && prixbase != "" && prixHT != "" && prixTTC != "") {
        btn_produit.textContent = "En cours...";
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data: data,
            success: function (data) {
                $("#modal_prod").modal('hide');
                getProduit();
                $('#message').html('');
                if (data.status == 'success') {
                    $('#message').append(
                        '<div class="alert alert-success alert-dismissable">' +
                        '<button type="button" class="close" data-dismiss="alert">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '<span class="sr-only">Close</span>' +
                        '</button>' +
                        data.message +
                        '</div>'
                    );
                    setTimeout(function () {
                        $("#message").remove();
                        location.reload();
                    }, 2000);
                } else {
                    $('#message').append(
                        '<div class="alert alert-danger alert-dismissable">' +
                        '<button type="button" class="close" data-dismiss="alert">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '<span class="sr-only">Close</span>' +
                        '</button>' +
                        data.message +
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
    } else {
        let small = document.getElementById("message_error");
        small.innerHTML = "Veuilez remplir tous les champs!";
        small.classList.remove('text-success');
        small.classList.add('text-danger');
    }
}

/**
 * recupération des infos d'un client pour v1
 */
function getClientInfos() {
    var client = document.getElementById("nomClient").value;
    if (client != null) {
        var client_id = document.querySelector(
            "#infos" + " option[value='" + client + "']"
        ).dataset.id;
        if (client_id) {
            $("#nouveauClient").fadeOut(5000);
        }
        var data = {
            id: client_id,
        };
        let url = Routing.generate("client_facture");
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data: data,
            success: function (data) {
                console.log(data);
                $("#nouveauClient").fadeOut(5000);
                $.each(data, function (key, val) {
                    document.getElementById("tel").value = val.tel;
                    document.getElementById("tel2").value = val.tel2;
                    document.getElementById("pays").value = val.paysClient;
                    document.getElementById("email").value = val.email;
                    document.getElementById("prenom").value = val.prenomClient;
                    document.getElementById("numSerieEntreprise").value = val.numeroDeSerieClient;
                    document.getElementById("titreEntreprise").value = val.titreEntrepriseClient;
                    document.getElementById("email").value = val.email;
                    document.getElementById("numRue").value = val.numRueClient;
                    document.getElementById("nomRue").value = val.nomRueClient;
                    document.getElementById("codePostal").value = val.codePostalClient;
                    document.getElementById("ville").value = val.villeClient;
                    document.getElementById("fixe").value = val.fixe;
                    document.getElementById("conditionV1").value = val.coditionDePaiement;
                    document.getElementById("adresseFactureClient").value = val.adresseFactureClient
                    var condition = val.coditionDePaiement;
                    console.log(val.codePostalClient);
                });
            },
            error: function (response) {
                console.log(response);
            },
        });
    }

}
/**
 * recupération des infos d'un client pour l'edition
 */
function getClientInfosE() {
    var client = document.getElementById("nomClientE").value;
    var client_id = document.querySelector(
        "#infosE" + " option[value='" + client + "']"
    ).dataset.id;
    console.log(client_id);
    var data = {
        id: client_id,
    };
    let url = Routing.generate("client_facture");
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (data) {
            console.log(data);
            $.each(data, function (key, val) {
                document.getElementById("telE").value = val.tel;
                document.getElementById("tel2E").value = val.tel2;
                document.getElementById("paysE").value = val.paysClient;
                document.getElementById("emailE").value = val.email;
                document.getElementById("prenomE").value = val.prenomClient;
                document.getElementById("numSerieEntrepriseE").value = val.numeroDeSerieClient;
                document.getElementById("titreEntrepriseE").value = val.titreEntrepriseClient;
                document.getElementById("emailE").value = val.email;
                document.getElementById("emailE").value = val.email;
                document.getElementById("numRueE").value = val.numRueClient;
                document.getElementById("nomRueE").value = val.nomRueClient;
                document.getElementById("codePostalE").value = val.codePostalClient;
                document.getElementById("villeE").value = val.villeClient;
                document.getElementById("fixeE").value = val.fixe;
                document.getElementById("conditionE").value = val.coditionDePaiement;
                document.getElementById("adresseFactureClientE").value = val.adresseFactureClient
                var condition = val.coditionDePaiement;
                console.log(val.codePostalClient);
            });
        },
        error: function (response) {
            console.log(response);
        },
    });
}
/*************************************** client ******************************** */
// ajout Client
function ajoutClient() {
    var nom = document.getElementById("nom").value;
    var pays = document.getElementById("pays").value;
    var prenom = document.getElementById("prenom").value;
    var email = document.getElementById("email").value;
    var numRue = document.getElementById("numRue").value;
    var nomRue = document.getElementById("nomRue").value;
    var codePostal = document.getElementById("codePostal").value;
    var ville = document.getElementById("ville").value;
    var fixe = document.getElementById("fixe").value;
    var portable1 = document.getElementById("portable1").value;
    var portable2 = document.getElementById("portable2").value;
    var condition = document.getElementById("condition").value;
    var nomSociete = document.getElementById("nomSociete").value;
    var numSerie = document.getElementById("numSerie").value;
    var titreSociete = document.getElementById("titreSociete").value;
    var adresse = document.getElementById("adresse").value;
    if (checkInputClient(email, numRue, nomRue, codePostal, portable1, condition, adresse)) {
        var data = {
            nom: nom, prenom: prenom, email: email, numRue: numRue, pays: pays, nomRue: nomRue, codePostal: codePostal,
            ville: ville, fixe: fixe, portable1: portable1, adresse: adresse, portable2: portable2, condition: condition,
            nomSociete: nomSociete, numSerie: numSerie, titreSociete: titreSociete
        }
        var v2btn = document.getElementById("btn-ajoutClient");
        let url = v2btn.getAttribute("data-path");
        v2btn.textContent = "En cours..."
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data: data,
            success: function (result) {
                $("#modal-client").modal('hide');
                getClients()
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
                alert('Something went wrong');
            },
        });
    }
}

/****************************valide client*************************************** */
function checkInputClient(email, numRue, nomRue, codePostal, portable1, condition, adresse) {
    $result = $("#message_email");
    if (email != "") {
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1, 3}\.[0-9]{1, 3}\.[0-9]{1, 3}\.[0-9]{1, 3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (re.test(email)) {
            return true;
        } else {
            $result.text("Mail non valide");
            $result.css("color", "red");
            return false;
        }
    } else {
        $result.text("veuillez remplir le champ email!");
        $result.css("color", "red");
        return false;
    }

    //numRue
    if (numRue != "") {
        return true;
    } else {
        $result.text("veuillez remplir le champ numéro rue!");
        $result.css("color", "red");
        return false;
    }
    //nomRue
    if (nomRue != "") {
        return true;
    } else {
        $result.text("veuillez remplir le champ nom rue!");
        $result.css("color", "red");
        return false;
    }
    //code podtal
    if (codePostal != "") {
        return true;
    } else {
        $result.text("veuillez remplir le champ code postal!");
        $result.css("color", "red");
        return false;
    }
    if (portable1 != "") {
        return true;
    } else {
        $result.text("veuillez remplir le champ portable!");
        $result.css("color", "red");
        return false;
    }
}

// const codePostal = document.querySelector("#codePostal");
// $("#save").on('click', function () {
//   if (validateZipCode(codePostal.value)) {
//     console.log("server");
//   }
// });



// $("#codePostal").on('input', function () {
//   validateZipCode(this.value);
// });

// function validateZipCode(elementValue) {
//   var zipCodePattern = /^\d{5}$|^\d{5}-\d{4}$/;
//   if (zipCodePattern.test(elementValue)) {
//     console.log("true");
//     $("#codePostal").removeClass("invalid-code");

//     return true;
//   } else {
//     console.log("false");
//     $("#codePostal").addClass("invalid-code");
//     return false;
//   }
// }

// nouveau client v2
function nouveauV2Client() {
    var nom = document.getElementById("nom").value;
    var prenom = document.getElementById("prenom").value;
    var email = document.getElementById("email").value;
    var numRue = document.getElementById("numRue").value;
    var nomRue = document.getElementById("nomRue").value;
    var codePostal = document.getElementById("codePostal").value;
    var ville = document.getElementById("ville").value;
    var fixe = document.getElementById("fixe").value;
    var portable1 = document.getElementById("portable1").value;
    var portable2 = document.getElementById("portable2").value;
    var condition = document.getElementById("condition").value;
    var nomSociete = document.getElementById("nomSociete").value;
    var numSerie = document.getElementById("numSerie").value;
    var titreSociete = document.getElementById("titreSociete").value;
    var adresse = document.getElementById("adresse").value;

    var data = {
        nom: nom, prenom: prenom, email: email, numRue: numRue, nomRue: nomRue, codePostal: codePostal,
        ville: ville, fixe: fixe, portable1: portable1, adresse: adresse, portable2: portable2, condition: condition,
        nomSociete: nomSociete, numSerie: numSerie, titreSociete: titreSociete
    }
    var v2btn = document.getElementById("btn-clientNouveau");
    let url = v2btn.getAttribute("data-path");
    v2btn.textContent = "En cours..."
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (data) {
            console.log(data);
            v2btn.textContent = "Effectué"
            $("#modal-client").modal('hide');
            getClients();
        },
        error: function (response) {
            console.log(response);
        },
    });
}
// autocomplete date echeance V1
function completeEcheanceE() {
    const date = document.getElementById("dateE").value;
    const condition = document.getElementById("conditionE").value;
    const jour = new Date(date);
    const jours = jour.getDate();
    const e = new Date(new Date().setDate(parseInt(jour.getDate()) + parseInt(condition)));
    // formaté le date 
    function formatDate(e) {
        var d = new Date(e),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();
        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;
        return [year, month, day].join('-');
    }
    var dateString = formatDate(e);
    document.getElementById("echeanceE").value = dateString;
}
function getDataByOnProduct(index = 2) {
    console.log(index);
    var listproduit = document.getElementById("ref_" + index).value;
    var produit_id = document.querySelector(
        "#listProd" + " option[value='" + listproduit + "']"
    ).dataset.id;
    console.log(produit_id);
    var data = {
        id: produit_id,
    };
    let url = Routing.generate("infos_produit");
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (data) {
            console.log(data);
            $.each(data, function (key, val) {
                document.getElementById("prixUnit_" + index).value = val.prixUHT;
            });
        },
        error: function (response) {
            console.log(response);
        },
    });
}

/**
 * recherche client par nom
*/
function rechercheClient() {
    var input = document.getElementById("filter-name").value;
    var data = {
        key: input,
    };
    let url = Routing.generate("filter-name");
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (data) {
            console.log(data)
            var len = data.length;
            $("#my-table-id tbody").empty();
            var myTableBody = $("#my-table-id tbody");
            if (len > 0) {
                $.each(data, function (key, val) {

                    $("#my-table-id > tbody").append(
                        "<tr>" +
                        "<td><input type='checkbox' name='ids' value='" + val.id + "' class='checkclient'>" +
                        "</td>" +
                        "<td>" +
                        val.ref +
                        "</td>" +
                        "<td>" +
                        val.nomClient +
                        "</td>" +
                        "<td>" +
                        val.tel +
                        "</td>" +
                        "<td>" +
                        val.fixe +
                        "</td>" +
                        "<td>" +
                        val.coditionDePaiement +
                        "</td>" +
                        "<td>" +
                        val.email +
                        "</td>" +
                        "<td>" +
                        val.adresseFactureClient +
                        "</td>" +
                        "</tr>"
                    );
                });
            } else {
                var tr_ =
                    "<tr>" +
                    "<td align='center' colspan='4'>" +
                    "<strong class='mx-2'>" +
                    input +
                    "</strong>" +
                    "n'existe pas" +
                    "</td>" +
                    "</tr>";
                myTableBody.append(tr_);
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
}

/**
 * recherche produit par nom
 */
function rechercheProduit() {
    var input = document.getElementById("filter").value;
    var data = {
        key: input,
    };
    let url = Routing.generate("recherche_produit");
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (data) {
            console.log(data);
            var len = data.length;
            $("#my-table tbody").empty();
            var myTableBody = $("#my-table tbody");
            if (len > 0) {
                $.each(data, function (key, val) {
                    $("#my-table > tbody").append(
                        "<tr>" +
                        "<td><input type='checkbox' name='ids' value='" + val.id + "' class='checkproduit'></input>" +
                        "<td>" +
                        val.ref +
                        "</td>" +
                        "<td>" +
                        val.comment +
                        "</td>" +
                        "<td>" +
                        val.nomProduit +
                        "</td>" +
                        "<td>" +
                        val.prixUHT + " " + "€" +
                        "</td>" +
                        "<td>" +
                        val.prixUTTC + " " + "€" +
                        "</td>" +
                        "</tr>"
                    );
                });
            } else {
                var tr_ =
                    "<tr>" +
                    "<td align='center' colspan='4'>" +
                    "<strong class='mx-2'>" +
                    input +
                    "</strong>" +
                    "n'existe pas" +
                    "</td>" +
                    "</tr>";
                myTableBody.append(tr_);
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
}

/**
 * get all produit
 */
function getProduit() {
    let url = document.getElementById('produit-container').getAttribute('data-path');
    $.ajax({
        type: "get",
        url: url,
        dataType: "json",
        success: function (data) {
            var len = data.length;
            document.getElementById("total_produit").textContent = len;
            $("#my-table tbody").empty();
            var myTableBody = $("#my-table tbody");
            if (len > 0) {
                $.each(data, function (key, val) {
                    $("#my-table > tbody").append(
                        "<tr>" +
                        "<td><input type='checkbox' name='ids' value='" + val.id + "' class='checkproduit'></input>" +
                        "<td>" +
                        val.ref +
                        "</td>" +
                        "<td>" +
                        val.nomProduit +
                        "</td>" +
                        "<td>" +
                        val.comment +
                        "</td>" +
                        "<td>" +
                        val.prixUHT + " " + "€" +
                        "</td>" +
                        "<td>" +
                        val.prixUTTC + " " + "€" +
                        "</td>" +
                        "</tr>"
                    );
                });
            } else {
                var tr_ =
                    "<tr>" +
                    "<td align='center' colspan='4'>" +
                    "<strong class='mx-2'>" +
                    input +
                    "</strong>" +
                    "n'existe pas" +
                    "</td>" +
                    "</tr>";
                myTableBody.append(tr_);
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
}

/**
 * get all clients
 */
function getClients() {

    var factures = document.getElementById("getClient");
    let url = factures.getAttribute("data-getClient");
    $.ajax({
        type: "get",
        url: url,
        dataType: "json",
        success: function (data) {
            var len = data.length;
            document.getElementById("total_client").textContent = len;
            $("#my-table-id tbody").empty();
            var myTableBody = $("#my-table-id tbody");
            if (len > 0) {
                $.each(data, function (key, val) {
                    $("#my-table-id > tbody").append(
                        '<tr>' +
                        '<td><input type="checkbox" name="ids" value="' + val.id + '" class="checkclient">' +
                        " </td>" +
                        "<td>" +
                        val.ref +
                        "</td>" +
                        "<td>" +
                        val.nomClient +
                        "</td>" +
                        "<td>" +
                        val.tel +
                        "</td>" +
                        "<td>" +
                        val.fixe +
                        "</td>" +
                        "<td>" +
                        val.coditionDePaiement +
                        "</td>" +
                        "<td>" +
                        val.email +
                        "</td>" +
                        "<td>" +
                        val.adresseFactureClient +
                        "</td>" +
                        "</tr>"
                    );
                });
            } else {
                var tr_ =
                    "<tr>" +
                    "<td align='center' colspan='4'>" +
                    "<strong class='mx-2'>" +
                    input +
                    "</strong>" +
                    "n'existe pas" +
                    "</td>" +
                    "</tr>";
                myTableBody.append(tr_);
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
}
// get client to select
function getClient() {
    var nom = $("#nomClient").val();
    var data = { nom: nom };
    let url = Routing.generate("clients");
    console.log(data);
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (result) {
            console.log()
            let len = result.length;
            if (len > 0) {

                $("#infos").empty();
                // console.log("ty");
                for (i = 0; i < result.length; i++) {
                    $("#infos").append(
                        '<option data-id="' +
                        result[i].id +
                        '" value="' +
                        result[i].nomClient +
                        '">' +
                        result[i].adresseFactureClient +
                        " <br> " +
                        result[i].tel +
                        "</option>"
                    );
                }
            } else {
                $("#nouveauClient").empty();
                $("#nouveauClient").append('<input type="button" class="btn btn-sm btn-primary my-2" value="Créer nouveau" onclick="gererNouveauClient()">' +
                    "</button>");
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
}

function gererNouveauClient() {
    $("#modal-client").modal("show");
}
function ajoutClientV1() {
    var nom = document.getElementById("nomV1").value;
    var pays = document.getElementById("paysV1").value;
    var prenom = document.getElementById("prenomV1").value;
    var email = document.getElementById("emailV1").value;
    var numRue = document.getElementById("numRueV1").value;
    var nomRue = document.getElementById("nomRueV1").value;
    var codePostal = document.getElementById("codePostalV1").value;
    var ville = document.getElementById("villeV1").value;
    var fixe = document.getElementById("fixeV1").value;
    var portable1 = document.getElementById("portable1V1").value;
    var portable2 = document.getElementById("portable2V1").value;
    var condition = document.getElementById("condition").value;
    var nomSociete = document.getElementById("nomSocieteV1").value;
    var numSerie = document.getElementById("numSerieV1").value;
    var titreSociete = document.getElementById("titreSocieteV1").value;
    var adresse = document.getElementById("adresseV1").value;

    var data = {
        nom: nom, prenom: prenom, email: email, numRue: numRue, pays: pays, nomRue: nomRue, codePostal: codePostal,
        ville: ville, fixe: fixe, portable1: portable1, adresse: adresse, portable2: portable2, condition: condition,
        nomSociete: nomSociete, numSerie: numSerie, titreSociete: titreSociete
    }
    console.log(data);
    let url = Routing.generate("ajoutClientV1");
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        beforeSend: function () {
            $("#btn-ajoutClient").attr("value", "Traitement en cours");
        },
        success: function (result) {
            $("#modal-client").modal('hide');
            $("#nouveauClient").fadeOut(2000);
            $.each(result, function (key, val) {
                document.getElementById("tel").value = val.tel;
                document.getElementById("tel2").value = val.tel2;
                document.getElementById("pays").value = val.paysClient;
                document.getElementById("email").value = val.email;
                document.getElementById("nomClient").value = val.nomClient;
                document.getElementById("prenom").value = val.prenomClient;
                document.getElementById("numSerieEntreprise").value = val.numeroDeSerieClient;
                document.getElementById("titreEntreprise").value = val.titreEntrepriseClient;
                document.getElementById("email").value = val.email;
                document.getElementById("numRue").value = val.numRueClient;
                document.getElementById("nomRue").value = val.nomRueClient;
                document.getElementById("codePostal").value = val.codePostalClient;
                document.getElementById("ville").value = val.villeClient;
                document.getElementById("fixe").value = val.fixe;
                document.getElementById("conditionV1").value = val.coditionDePaiement;
                document.getElementById("adresseFactureClient").value = val.adresseFactureClient
            });
        },
        error: function (response) {
            alert('Something went wrong');
        },
    });
}
// get client to select
function getClientE() {
    var nom = $("#nomClientE").val();
    var data = { nom: nom };
    let url = Routing.generate("clients");
    console.log(data);
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data,
        success: function (data) {
            let len = data.length;
            if (len > 0) {
                $("#infosE").empty();
                // console.log("ty");
                for (i = 0; i < data.length; i++) {
                    $("#infosE").append(
                        '<option data-id="' +
                        data[i].id +
                        '" value="' +
                        data[i].nomClient +
                        '">' +
                        data[i].adresseFactureClient +
                        " </br> " +
                        data[i].tel +
                        "</option>"
                    );
                }
            } else {
                $("#infosE").empty();
                var options = [];
                options[0] = new Option('New Client');
                $("#infosE").append(options);
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
}
// nouveau client 
$("#btn-client").on('click', function (e) {
    e.preventDefault();
    var nom = document.getElementById("nom").value;
    var prenom = document.getElementById("prenom").value;
    var email = document.getElementById("email").value;
    var numRue = document.getElementById("numRue").value;
    var nomRue = document.getElementById("nomRue").value;
    var codePostal = document.getElementById("codePostal").value;
    var ville = document.getElementById("ville").value;
    var fixe = document.getElementById("fixe").value;
    var portable1 = document.getElementById("portable1").value;
    var portable2 = document.getElementById("portable2").value;
    var condition = document.getElementById("condition").value;
    var nomSociete = document.getElementById("nomSociete").value;
    var numSerie = document.getElementById("numSerie").value;
    var titreSociete = document.getElementById("titreSociete").value;
    var adresse = document.getElementById("adresse");
    var data = {
        nom: nom, prenom: prenom, email: email, numRue: numRue, nomRue: nomRue, codePostal: codePostal,
        ville: ville, fixe: fixe, portable1: portable1, adresse: adresse, portable2: portable2, condition: condition,
        nomSociete: nomSociete, numSerie: numSerie, titreSociete: titreSociete
    }

    var submitClient = document.getElementById("btn-client");
    let url = submitClient.getAttribute("data-path");
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: JSON.stringify(data),
        success: function (data) {
            $("#modal-client").modal('hide');
            console.log(data);

        },
        error: function (response) {
            console.log(response);
        },
    });
})

/**
 * edit produit
 */
function editProduit() {
    $("#editProduit").modal('show');
    let edit = document.getElementById("edit");
    var path = edit.getAttribute("data-path");
    console.log(edit);
    $.ajax({
        type: "get",
        url: path,
        dataType: "json",
        success: function (data) {
            $.each(data, function (key, val) {
                document.getElementById("nomProduitE").value = val.nomProduit;
                document.getElementById("commentE").value = val.comment;
                document.getElementById("prixbaseE").value = val.prixBase;
                document.getElementById("prixHTE").value = val.prixUHT;
                document.getElementById("prixTTCE").value = val.prixUTTC;
                document.getElementById("tvaE").value = val.tva;
                document.getElementById("id").value = val.id;
            });

        },
        error: function (response) {
            console.log(response);
        },
    });

}
// modification produit action
function editActionProduit() {
    var nomProduitE = document.getElementById("nomProduitE").value;
    var commentE = document.getElementById("commentE").value;
    var prixBaseE = document.getElementById("prixbaseE").value;
    var prixHTE = document.getElementById("prixHTE").value;
    var prixTTCE = document.getElementById("prixTTCE").value;
    var tvaE = document.getElementById("tvaE").value;
    var id = document.getElementById("id").value;
    var data = {
        nomProduitE: nomProduitE, commentE: commentE, prixBaseE: prixBaseE, prixTTCE: prixTTCE, prixHTE: prixHTE,
        tvaE: tvaE, id: id
    }
    var buttonE = document.getElementById("btnproduitE");
    var path = buttonE.getAttribute("data-path");
    $.ajax({
        type: "post",
        url: path,
        dataType: "json",
        data: data,
        success: function (data) {
            $("#editProduit").modal('hide');
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
            getProduit();
        },
        error: function (response) {
            console.log(response);
        },
    });
}

$('select[name=tva]').change(function () {
    if ($(this).val() == '') {
        $("#modal_tva").modal('show');
    }
});
/**
 * delete config
 */
$("#paramDelete").click(function (e) {
    e.preventDefault();
    $(this).textContent = "Suppression..."
    var path = $(this).attr("data-path");
    console.log(path);
    $.ajax({
        url: path,
        type: "DELETE",
        success: function (response) {
            location.reload();
        },
        error: function (response) {
            console.log(response);
        },
    })

})

//*************************** facture ************************** */

/**
 * get all invoice
 */
function getAllInvoice() {
    var url = Routing.generate("factures");
    $.ajax({
        type: "get",
        url: url,
        dataType: "json",
        success: function (data) {
            var len = data.length;
            var len = data.length;
            $("#table_facture tbody").empty();
            $.each(data, function (key, val) {
                var urledit = Routing.generate("edit_facture");
                var urlimprimer = Routing.generate("print_invoice");
                var urldetail = Routing.generate("ligne_facture");
                $("#table_facture > tbody").append(
                    "<tr>" +
                    "<td scope='row'>" + val[0].ref + "</td>" +
                    "<td>" + val[0].date + "</td>" +
                    "<td>" + val[0].echeance + "</td>"
                    + "<td>" +
                    val.nomClient
                    +
                    "</td>"
                    + "<td>" + val.totalTTC + "</td > "
                    + "<td id='stat'>" + "</td > "
                    + "<td style='width:30px;' class='text-center'>" +
                    " <div class='dropdown mx-1'>" +
                    "<a class='' href='#' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>" +
                    "<i class='fas fa-ellipsis-v'></i> " +
                    "</a>" +
                    "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><a class='dropdown-item' onclick='supprimerFacture(" + val[0].id + ")' id='supprimerFac' data-id='" + val[0].id + "'  href='javascript:void(0)'>Supprimer</a>" +
                    "</li>" +
                    '<li><a href=' + urledit + "/" + val[0].id + ' onclick="editFacture()" class="dropdown-item" id="editFacture" data-path="{{path("edit_facture")}}" data-id="' + val[0].id + '">Modifier</a>' +
                    "</li>" +
                    '<li><a class="dropdown-item" href=' + urldetail + "/" + val[0].id + ">Détail</a>" +
                    "</li>" +
                    '<li><a class="dropdown-item" href=' + urlimprimer + "/" + val[0].id + ">Imprimer</a>" +
                    "</li>" +

                    "</ul>" +
                    "</div > " +
                    "</tr>"
                );
                if (val[0].etat == "0") {
                    $("#stat").append("<span><i class='fas fa-file-alt'></i></span>");
                }
                if (val[0].etat == "1") {
                    $("#stat").append("<span><i class='fas fa-mail-bulk'></i></span>");
                }
                if (val[0].etat == "2") {
                    $("#stat").append("<span><i class='fas fa-check text-success'></i></span>");
                }
                if (val[0].etat == "3") {
                    $("#stat").append("<span><i class='fas fa-check text-danger'></i></span>");
                }
            });
        },
        error: function (response) {
            console.log(response);
        },
    });
}

$("#filter-etat").on('change', function () {
    var url = Routing.generate('filter-etat');
    var value = $(this).val();
    console.log(value);
    $.ajax({
        type: "get",
        url: url,
        dataType: "json",
        data: { etat: value },
        success: function (data) {
            var len = data.length;
            $("#table_facture tbody").empty();
            var myTableBody = $("#table_facture tbody");
            if (len > 0) {
                $.each(data, function (key, val) {
                    var urledit = Routing.generate("edit_facture");
                    var urlimprimer = Routing.generate("print_invoice");
                    var urldetail = Routing.generate("ligne_facture");
                    var urlEnvoyer = Routing.generate("invoice_envoyer");
                    if (val[0].etat == 0) {
                        var etat = "<i class='fas fa-file-alt text-primary'></i>"
                    }
                    if (val[0].etat == "1") {
                        var etat = "<i class='fas fa-mail-bulk text-dark'></i>";
                    }
                    if (val[0].etat == "2") {
                        var etat = "<i class='fas fa-check text-success'></i>";
                    }
                    if (val[0].etat == "3") {
                        var etat = "<i class='fas fa-check text-danger'></i>";
                    }
                    $("#table_facture > tbody").append(
                        "<tr>"
                        + "<td scope='row'>" + val[0].ref + "</td>" +
                        "<td>" + val[0].date + "</td>" +
                        "<td>" + val[0].echeance + "</td>"
                        + "<td>" +
                        val.nomClient
                        +
                        "</td>"
                        + "<td>" + val.totalTTC + "</td > "
                        + "<td id='etat'>" + etat + "</td > "
                        + "<td style='width:30px;' class='text-center'>" +
                        "<div class='dropdown mx-1'><a class='#' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown'aria-expanded='false'>" +
                        "<i class='fas fa-ellipsis-v'></i>" +
                        "</a>" +
                        "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><a class='dropdown-item' onclick='supprimerFacture("
                        + val[0].id + ")' id='supprimerFac' data-id='" + val[0].id + "'  href='javascript:void(0)'>Supprimer</a>" +
                        "</li>" +
                        '<li><a href=' + urledit + "/" + val[0].id + ' class="dropdown-item" id="editFacture" data-path="{{path("edit_facture")}}" data-id="' + val[0].id + '">Modifier</a>' +
                        "</li>" +
                        '<li><a class="dropdown-item" href=' + urlimprimer + "/" + val[0].id + ">Imprimer</a>" +
                        "</li>" +
                        '<li><a class="dropdown-item" href=' + urldetail + "/" + val[0].id + ">Détail</a>" +
                        "</li>" +
                        "<li><a class='dropdown-item' href=" + urlEnvoyer + "/" + val[0].id + ">Envoyer</a>" +
                        "</li>" +
                        "</ul>" +
                        "</div>" +
                        "</td>" +
                        "</tr>"
                    );
                    if (val[0].etat == 0) {
                        let etat = "<i class='fas fa-mail-bulk'></i>"
                    }
                });
            } else {
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
});
/**
 * recherche facture par date
 */
$("#filter-date-invoice2").on('change', function () {
    var date = document.getElementById('filter-date-invoice').value;
    var date1 = $(this).val();
    var path = Routing.generate("filter-date");
    var urledit = Routing.generate("edit_facture");
    var urlimprimer = Routing.generate("print_invoice");
    var urldetail = Routing.generate("ligne_facture");
    var urlEnvoyer = Routing.generate("invoice_envoyer");
    $.ajax({
        type: "get",
        url: path,
        dataType: "json",
        data: { date: date, date1: date1 },
        success: function (data) {
            console.log(data);
            var len = data.length;

            $("#table_facture tbody").empty();
            var myTableBody = $("#table_facture tbody");
            if (len > 0) {
                $.each(data, function (key, val) {
                    if (val[0].etat == 0) {
                        var etat = "<i class='fas fa-file-alt text-primary'></i>"
                    }
                    if (val[0].etat == "1") {
                        var etat = "<i class='fas fa-mail-bulk text-dark'></i>";
                    }
                    if (val[0].etat == "2") {
                        var etat = "<i class='fas fa-check text-success'></i>";
                    }
                    if (val[0].etat == "3") {
                        var etat = "<i class='fas fa-check text-danger'></i>";
                    }
                    $("#table_facture > tbody").append(
                        "<tr>"
                        + "<td scope='row'>" + val[0].ref + "</td>" +
                        "<td>" + val[0].date + "</td>" +
                        "<td>" + val[0].echeance + "</td>"
                        + "<td>" +
                        val.nomClient
                        +
                        "</td>"
                        + "<td>" + val.totalTTC + "</td > "
                        + "<td id='stat'>" + etat + "</td > "
                        + "<td style='width:30px;' class='text-center'>" +
                        "<div class='dropdown mx-1'><a class='' id='dropdownMenuButton1' data-bs-toggle='dropdown'aria-expanded='false'>" +
                        "<i class='fas fa-ellipsis-v'></i>" +
                        "</a>" +
                        "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><a class='dropdown-item' onclick='supprimerFacture(" + val[0].id + ")' id='supprimerFac' data-id='" + val[0].id + "'  href='javascript:void(0)'>Supprimer</a>" +
                        "</li>" +
                        '<li><a href=' + urledit + "/" + val[0].id + ' onclick="editFacture()" class="dropdown-item" id="editFacture" data-path="{{path("edit_facture")}}" data-id="' + val[0].id + '">Modifier</a>' +
                        "</li>" +
                        "<li><a class='dropdown-item' href=" + urlimprimer + "/" + val[0].id + ">Imprimer</a>" +
                        "</li>" +
                        "<li><a class='dropdown-item' href=" + urldetail + "/" + val[0].id + ">Détail</a>" +
                        "</li>" +
                        "<li><a class='dropdown-item' href=" + urlEnvoyer + "/" + val[0].id + ">Envoyer</a>" +
                        "</li>" +
                        "</ul>" +
                        "</div>" +
                        "</td>" +
                        "</tr>"
                    );

                });
            } else {
                var tr_ =
                    "<tr>" +
                    "<td align='center' colspan='12'>" +
                    "<strong class='mx-2'>" +
                    date +
                    "</strong>" +
                    "n'existe pas" +
                    "</td>" +
                    "</tr>";
                myTableBody.append(tr_);
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
});

/**
  * recherche facture par reference
  */
function searcheInvoice() {
    var urledit = Routing.generate("edit_facture");
    var urlEnvoyer = Routing.generate("invoice_envoyer");
    var urlimprimer = Routing.generate("print_invoice");
    var urldetail = Routing.generate("ligne_facture");
    var inputSearche = document.getElementById("inputInvoice").value;
    var ref = {
        key: inputSearche,
    };
    var datapath = document.getElementById("inputInvoice").getAttribute("data-path");
    $.ajax({
        type: "post",
        url: datapath,
        dataType: "json",
        data: ref,
        success: function (data) {
            console.log(data);
            var len = data.length;
            $("#table_facture tbody").empty();
            var myTableBody = $("#table_facture tbody");
            if (len > 0) {
                $.each(data, function (key, val) {
                    if (val[0].etat == 0) {
                        var etat = "<i class='fas fa-file-alt text-primary'></i>"
                    }
                    if (val[0].etat == "1") {
                        var etat = "<i class='fas fa-mail-bulk text-dark'></i>";
                    }
                    if (val[0].etat == "2") {
                        var etat = "<i class='fas fa-check text-success'></i>";
                    }
                    if (val[0].etat == "3") {
                        var etat = "<i class='fas fa-check text-danger'></i>";
                    }
                    $("#table_facture > tbody").append(
                        "<tr>"
                        + "<td scope='row'>" + val[0].ref + "</td>" +
                        "<td>" + val[0].date + "</td>" +
                        "<td>" + val[0].echeance + "</td>"
                        + "<td>" +
                        val.nomClient
                        +
                        "</td>"
                        + "<td>" + val.totalTTC + "</td > "
                        + "<td id='stat'>" + etat + "</td > "
                        + "<td style='width:30px;' class='text-center'>" +
                        "<div class='dropdown mx-1'><a class='' id='dropdownMenuButton1' data-bs-toggle='dropdown'aria-expanded='false'>" +
                        "<i class='fas fa-ellipsis-v'></i>" +
                        "</a>" +
                        "<ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'><li><a class='dropdown-item' onclick='supprimerFacture(" + val[0].id + ")' id='supprimerFac' data-id='" + val[0].id + "'  href='javascript:void(0)'>Supprimer</a>" +
                        "</li>" +
                        '<li><a href=' + urledit + "/" + val[0].id + ' onclick="editFacture()" class="dropdown-item" id="editFacture" data-path="{{path("edit_facture")}}" data-id="' + val[0].id + '">Modifier</a>' +
                        "</li>" +
                        "<li><a class='dropdown-item' href=" + urlimprimer + "/" + val[0].id + ">Imprimer</a>" +
                        "</li>" +
                        "</li>" +
                        "<li><a class='dropdown-item' href=" + urldetail + "/" + val[0].id + ">Détail</a>" +
                        "</li>" +
                        "<li><a class='dropdown-item' href=" + urlEnvoyer + "/" + val[0].id + ">Envoyer</a>" +
                        "</li>" +
                        "</ul>" +
                        "</div>" +
                        "</td>" +
                        "</tr>"
                    );
                });
            } else {
                var tr_ =
                    "<tr>" +
                    "<td align='center' colspan='4'>" +
                    "<strong class='mx-2'>" +
                    inputSearche +
                    "</strong>" +
                    "n'existe pas" +
                    "</td>" +
                    "</tr>";
                myTableBody.append(tr_);
            }
        },
        error: function (response) {
            console.log(response);
        },
    });
}
// facture en brouillon
function factureBrouillon() {
    var num = document.getElementById("numV2").value;
    var refV2 = document.getElementById("refV2").textContent;
    var prefixe = document.getElementById("prefixeV2").value;
    var client = document.getElementById("nomClient").value;
    var condition = document.getElementById("condition").value;
    var clientid = document.querySelector(
        "#infos" + " option[value='" + client + "']"
    ).dataset.id;
    var url = Routing.generate("bruillon");
    if (client !== null && client !== '') {
        console.log($('#add_ligne').serialize());
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data: $('#add_ligne').serialize() + '&prefixe=' + prefixe + '&clientid=' + clientid + '&num=' + num + '&reference=' + refV2,
            beforeSend: function () {
                $("#btn-brouillon").attr("value", "Traitement en cours...")
            },
            success: function (data) {
                var url = Routing.generate('invoice');
                window.location = url;
            },
            error: function (response) {
                console.log(response);
            },
        });
    } else {
        alert("Veuillez remplire le client");
    }
}
// facture en brouillon
function factureEnregistrer() {
    var num = document.getElementById("numV2").value;
    var prefixe = document.getElementById("prefixeV2").value;
    var refV2 = document.getElementById("refV2").textContent;
    var client = document.getElementById("nomClient").value;
    var condition = document.getElementById("condition").value;
    var url = Routing.generate("enregister_facture");
    console.log($('#add_ligne').serialize());
    var clientid = document.querySelector(
        "#infos" + " option[value='" + client + "']"
    ).dataset.id;
    if (client !== null && client !== '') {
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data: $('#add_ligne').serialize() + '&clientid=' + clientid + '&prefixe=' + prefixe + '&num=' + num + '&reference=' + refV2,
            beforeSend: function () {
                $("#save_invoice").attr("value", "Traitement en cours...")
            },
            success: function (result) {
                $('#message').html('');
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
                var path = document.getElementById("redirect");
                var x = path.getAttribute("data-path");
                window.location = x;

            },
            error: function (response) {
                console.log(response);
            },
        });
    } else {
        alert("Veuillez remplire le client");
    }

}
/**
 * valider edit facture
 */
function editerFacture() {
    var data = $('#edit-form').serialize();
    //dannés facture
    var prefixe = document.getElementById("prefixeE").value;
    var date = document.getElementById("dateE").value;
    var num = document.getElementById("numE").value;
    var echeance = document.getElementById("echeanceE").value;
    var client = document.getElementById("nomClientE").value;
    var cli = document.getElementById("nomClientE");
    var idCli = cli.getAttribute("data-id");
    if (idCli != null) {
        var id = idCli;
    } else {
        var clientid = document.querySelector(
            "#infos" + " option[value='" + client + "']"
        ).dataset.id;
        var id = clientid;
    }
    console.log(data);
    var ref = prefixe + "-" + num;

    if (client !== null && client !== '') {
        var url = Routing.generate('edit');
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data: $('#edit-form').serialize() + '&idClient=' + id + '&num=' + num + '&reference=' + ref + '&echeance=' + echeance + '&date=' + date,
            beforeSend: function () {
                $("#btn-edit").attr("value", "Traitement en cours...")
            },
            success: function (data) {
                var url = Routing.generate('invoice');
                window.location = url;
            },
            error: function (response) {
                console.log(response);
            },
        });
    } else {
        alert("Veuillez remplire le client");
    }
}

/**
 * valider facture v1
 */
function validerFactureV1() {
    var data = $('#fac-form').serialize();
    //dannés facture
    var prefixe = document.getElementById("prefixeV1").value;
    var date = document.getElementById("dateV1").value;
    var num = document.getElementById("numV1").value;
    var echeance = document.getElementById("echeanceV1").value;
    var client = document.getElementById("nomClient").value;
    var clientid = document.querySelector(
        "#infos" + " option[value='" + client + "']"
    ).dataset.id;
    console.log(data);
    if (client !== null && data != "") {
        var url = Routing.generate('enregister_facture');
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data: $('#fac-form').serialize() + '&clientid=' + clientid + '&prefixe=' + prefixe + '&num=' + num + '&reference=' + ref + '&echeance=' + echeance + '&date=' + date,
            beforeSend: function () {
                $("#validerV1").attr("value", "Traitement en cours...")
            },
            success: function (data) {
                var url = Routing.generate('invoice');
                window.location = url;
            },
            error: function (response) {
                console.log(response);
            },
        });
    } else {
        alert("vous avez oublié le client");
    }
}
//supprimer facture
function supprimerFacture($id) {
    var url = Routing.generate("supprimer_facture");
    var id = $id;
    console.log(url);
    $.ajax({
        url: url,
        type: "DELETE",
        data: { 'id': id },
        success: function (result) {
            $('#message').html('');
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
            setTimeout(window.location.reload.bind(window.location), 250);
        },
        error: function (result) {
            console.log(result);
        },

    })
}



$("input[name = 'ids']").click(function () {

    var nombre_selectionne = $(":checkbox:checked").length;


    if (nombre_selectionne > 1) {
        document.getElementById("editProduitBtn").style.display = "none";
    }
    else {
        document.getElementById("editProduitBtn").style.display = "block";
    }


    if ($('input[name="ids"]:checked').length > 0) {
        document.getElementById("dropdownMenuButton1").disabled = false;
    }
    else {
        document.getElementById("dropdownMenuButton1").disabled = true;
    }
});

