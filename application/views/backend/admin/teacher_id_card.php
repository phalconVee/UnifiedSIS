    
   
<hr/>

<?php
    $system_name   = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
    $system_title  = $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
    $address       = $this->db->get_where('settings' , array('type'=>'address'))->row()->description;
?>

<div class="container">

    <div class="col-md-12">
        <blockquote class="blockquote-blue">
           Select the user from the dropdown to get their data auto filled in the ID card template below. Note that you can double click where you want to add your information below in the ID CARD template
        </blockquote>
    </div>
   

    <div id="myModal" class="modal">
        <div class="modal-dialog">

          <!-- Modal content -->
          <div id="modal-content" class="modal-content printableArea" style="margin-top:100px;">
            <div><span class="close">&times;</span></div>            

            <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
                <center>
                    <a id="btn-Convert-Html2Image" class="btn btn-default btn-icon icon-left hidden-print pull-left" href="#">
                    Download 
                    <i class="entypo-download"></i>
                    </a>
                </center>
                
            </div>           

          </div>

        </div>
    </div>

    <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-11">
        <div class="row">

                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Select a teacher</label>
                        <select name="teacher" id="teacher_id" class="form-control" style="width: 250px;">
                            <option value=""><?php echo get_phrase('select');?></option>
                            <?php 
                            $teachers = $this->db->get('teacher')->result_array();
                            foreach($teachers as $row):
                            ?>
                                <option value="<?php echo $row['teacher_id'];?>">
                                        <?php echo $row['name'];?>
                                </option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                        <br/>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <center>
                                <label>Image for teacher's Signature </label>
                                <span class="btn btn-xs btn-file" style="background-color: #DDD;margin-left: 38px;">
                                    <span class="fileinput-new">Upload</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="userfile" accept="image/*" onChange="readURL_teacher(this);">
                                </span>
                            </center>
                        </div>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <center>
                                <label>Image for Principle's Signature </label>
                                <span class="btn btn-xs btn-file" style="background-color: #DDD;margin-left: 33px;">
                                    <span class="fileinput-new">Upload</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="userfile" accept="image/*" onChange="readURL_principle(this);">
                                </span>
                            </center>
                        </div>
                        <div style="margin-left: 50px;">(150 X 30)</div>
                        
                    </div>
                </div>

        </div>

        <hr/>

        <div id="html-content-holder" class="area" style="background-color: #fff;">
            <div class="side">
                <center>
                    <!--<img src="uploads/logo.png" width="52" height="47">-->

                    <img src="<?php echo base_url();?>image.php/uploads/logo.png?width=200&height=47&cropratio=1:1&image=<?php echo base_url();?>uploads/logo.png" />

                    <br/>
                    <div class="title">
                        <p style="font-size: 16px;"><?=$system_name;?></p>
                    </div>
                    <div class="title_bottom">
                        <p style="font-size: 12px;"><?=$address?></p>
                    </div>
                    <!-- <div class="photo"> -->
                        <img class="photo" id="photo" src="" width="114" height="122">
                    <!-- </div> -->
                    <div class="name">
                        <p id="teacher_name">Bigbros Labs</p>
                    </div>
                </center>
                <div style="height: 10px;"></div>

               

                <div class="detail-content" style="width: 320px;height: 26px;font-size: 12px;">
                    <div style="float: left;padding-right: 7px;"><label>Date of birth :</label></div>
                    <div style="float: left;padding-right: 7px;" id="teacher_dob"><p>20/09/1987</p></div>
                    <div style="float: left;padding-right: 7px;"><label>Gender :</label></div>
                    <div style="float: left;padding-right: 7px;" id="teacher_gender"><p>Male</p></div>
                </div>

                <div class="detail-content" style="width: 320px;height: 26px;font-size: 12px;">
                    <div style="float: left;padding-right: 7px;"><label>Address :</label></div>
                    <div style="float: left;padding-right: 7px;" id="teacher_address"><p> 2014 Illinois Avenue | 503-762-2429</p></div>
                </div>

                <div class="detail-content" style="width: 320px;height: 26px;font-size: 12px;">
                    <div style="float: left;padding-right: 7px;"><label>Phone : </label></div>
                    <div style="float: left;padding-right: 7px;" id="teacher_phone"><p>+91 90325 81559</p></div>
                    <div style="float: left;padding-right: 7px;"><label>Valid Till :</label></div>
                    <div style="float: left;padding-right: 7px;"><p>31 March, 2018</p></div>
                </div>
                <br/>

                <div class="detail-content" style="width: 320px;height: 20px;font-size: 12px;">
                    <div style="padding-right: 7px;height: 30px;">
                        <label>teacher's signature :</label>
                        <img id="teacher_sign" src="uploads/sign.png" alt="" style="margin-top: -2px;" />
                    </div>
                    <div style="padding-right: 7px;height: 30px;">
                        <label>Principle's signature :</label>
                        <img id="principle_sign" src="uploads/sign.png" alt="" style="margin-top: -2px;" />
                    </div>
                </div>
            </div>

            <div class="side">

                <center>
                    <img src="<?php echo base_url();?>image.php/uploads/logo.png?width=200&height=47&cropratio=1:1&image=<?php echo base_url();?>uploads/logo.png" />
                </center>

                <div style="height: 50px;"></div>
                <div class="detail-content">
                    <label>Our Office</label>
                    <div><p>08 Esietedo Street, Alakija,</p></div>
                    <div><p>Lagos, 110001</p></div>
                </div>

                <div style="height: 7px;"></div>
                <div class="detail-content">
                    <label>Phone</label>
                    <div><p>+2348166601864</p></div>
                    <div><p>+2348103600756</p></div>
                </div>

                <div style="height: 7px;"></div>
                <div class="detail-content">
                    <label>Email</label>
                    <div><p>info@bigbroslab.com</p></div>
                    <div><p>support@bigbroslab.com</p></div>
                </div>

                <div style="height: 7px;"></div>
                <div class="detail-content">
                    <label>Website</label>
                    <p>www.bigbroslab.com</p>
                </div>

            </div>
        </div>
        <br/>
        

        <input type="button" name="" id="myBtn" class="btn btn-info" value="Preview">

        
        <div id="previewImage"></div>
    </div>
    </div>
</div>


<script>
var element = $("#html-content-holder"); // global variable
var getCanvas; // global variable
$(document).ready(function(){
    show_photo();
    show_phone();
    show_name();
    show_dob();
    show_gender();
    show_address();
})

$("#btn-Preview-Image").on('click', function () {
         html2canvas(element, {
         onrendered: function (canvas) {
                // $("#previewImage").append(canvas);
                getCanvas = canvas;
             }
         });
    });

$("#btn-Convert-Html2Image").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "Id_Card.png").attr("href", newData);
    });

var times = 1;
$('#teacher_id').on('click', function(){
    show_photo();
    show_phone();
    show_name();
    show_dob();
    show_gender();
    show_address();
    
});

function vertical_show() {
    $('#html-content-holder').show();
}

function horizontal_show() {
    $('#html-content-holder').hide();
}

function show_photo() {
    if (times) {
        var select = $('#teacher_id');
        var value = select[0].value;
        var photo = document.getElementById("photo");
        photo.src = "uploads/teacher_image/"+value+".jpg";
        times = -1;
    }
    times++;
}

function show_phone() {
  
    var select = $('#teacher_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_teacher_phone',
        data: "teacher_id="+value,
        success: function(response) {
            jQuery("#teacher_phone").html(response);
        }
    });        
}

function show_name() {
  
    var select = $('#teacher_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_teacher_name',
        data: "teacher_id="+value,
        success: function(response) {
            jQuery("#teacher_name").html(response);
        }
    });        
}

function show_dob() {
  
    var select = $('#teacher_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_teacher_dob',
        data: "teacher_id="+value,
        success: function(response) {
            jQuery("#teacher_dob").html(response);
        }
    });        
}

function show_gender() {
  
    var select = $('#teacher_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_teacher_gender',
        data: "teacher_id="+value,
        success: function(response) {
            jQuery("#teacher_gender").html(response);
        }
    });        
}

function show_address() {
  
    var select = $('#teacher_id');
    var value = select[0].value;

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>index.php?loadidcardajax/show_teacher_address',
        data: "teacher_id="+value,
        success: function(response) {
            jQuery("#teacher_address").html(response);
        }
    });        
}

var temp_element;

$('p').on('dblclick', function() {
    temp_element = $(this);
    var value = $(this).html();
    var parent = $(this).parent();
    console.log(value);
    // alert("OK");
    $(this).hide();
    parent.append( "<div id='child'><input type='text' id='text' onchange='myFunction()' onblur='myFunction()' value='"+value+"'></div>" );
});

function myFunction() {
    var elem = document.getElementById("text");
    var value = elem.value;
    console.log(temp_element);
    temp_element.show();
    temp_element.html(value);
    elem.parentNode.removeChild(elem);

}

function readURL_teacher(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#teacher_sign')
                .attr('src', e.target.result)
                .width(150)
                .height(24);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL_principle(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#principle_sign')
                .attr('src', e.target.result)
                .width(150)
                .height(24);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var elem2 = document.getElementById("modal-content");

// When the user clicks the button, open the modal 
btn.onclick = function() {
    var elem = document.getElementById("html-content-holder");
    var temp = elem.cloneNode(true);
    elem2.append(temp);
    modal.style.display = "block";
    var elem = document.getElementById("html-content-holder");
    html2canvas(elem, {
    onrendered: function (canvas) {
        // $("#previewImage").append(canvas);
        getCanvas = canvas;
     }
    });
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    var elem = document.getElementById("html-content-holder");
    elem.parentNode.removeChild(elem);
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        var elem = document.getElementById("html-content-holder");
        elem.parentNode.removeChild(elem);
        modal.style.display = "none";
    }
}
</script>



