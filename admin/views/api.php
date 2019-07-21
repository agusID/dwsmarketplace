
<div class="panelTitle">
	APIs &amp; Services
</div>
<div class="panel">
<form method="post">
	<?php
    if(isset($_POST['save'])){        


            $data = array(
                'api_name'    => $p->anti_injection($_POST['txtAPI']),
                'api_key'     => $p->anti_injection($_POST['txtApiKey'])
            );
            
            $p->save($db, $data, "APIs", "api");
    
	}

	if(isset($_GET['delete'])){
        $id = $p->anti_injection($_GET['id']);

		$sql = "DELETE FROM APIs WHERE id = '".$id."'";
		$db->query($sql);
		$p->message('Api has been removed');
		$p->redirect('api');
	}

	?>

    <table>
        <tr>
            <td>API Name</td>
            <td colspan="2"><input type="text" required name="txtAPI"></td>
        </tr>
    	<tr>
        	<td width="80px">Key</td>
            <td width="100px">
            <div id="api_key"></div>
            <input type="hidden" id="txt_api_key" name="txtApiKey"/>
            </td>
            <td>
			<button type="button" id="generate" onclick="generateKey()" class="btn-cancel"><i class="glyphicon glyphicon-refresh"></i> Generate</button>
			</td>
        </tr>
        <tr>
            <td colspan="3"><button type="submit" name="save" class="btn-action" style="margin: 0;"><i class="glyphicon glyphicon-plus"></i> Add Key</button></td>
        </tr>
    </table>
    <h4 class="title">API Key</h4>
<p class="subtitle">The API key is used to access the available APIs</p>    
    <table class='table' style="margin-top: 10px">
        <thead>

            <tr>
                <th>Name</th>
                <th width="150px">Created at</th>
                <th>Key</p></th>
                <th align="center"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $batas = 10;
        $posisi = $p->get_position($batas);
        $sql = mysqli_query($db, "SELECT * FROM APIs
        
        LIMIT $batas
        ");
        $jumlahdata = mysqli_num_rows(mysqli_query($db, "SELECT * FROM APIs "));
        $jumlahhalaman = $p->total_page($jumlahdata, $batas);
        $no = $posisi;
        while($r = mysqli_fetch_array($sql)){
        $no++;
        ?>

        <tr>
            <td><?php echo $r['api_name']; ?></td>
            <td>
            <?php 
                $date = new DateTime($r['created_at']);
				echo $date->format('F d, Y');  ?>
            </td>
            <td>
            <span onclick="copy(<?php echo $no; ?>)" class="greyColor glyphicon glyphicon-duplicate"></span><span onclick="copy(<?php echo $no; ?>)" style="min-width: 350px; display: inline-block; cursor:pointer;">&nbsp;<?php echo $r['api_key']; ?></span>
                <input type="text" style="margin:0; width:1px; height: 1px; opacity: 0; float:left" value="<?php echo $r['api_key']; ?>" id="keyID<?php echo $no; ?>">
            </td>
            <td align="center"><a onclick="return confirm('Are you sure?')" style="margin:0" href="<?php echo 'remove-api-'.$r[0].'' ?>"><i class="glyphicon glyphicon-remove"></i></a></td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
	<div class="boxPagination">
	<?php
		$page = $p->anti_injection($_GET['page']);
		$p->pagination($jumlahhalaman, $page, "api.");
	?>
	</div>
</form>

<script>

function copy(id) {
    var copyText = document.getElementById("keyID"+id);
    copyText.select();
    document.execCommand("Copy");
    alert("Text Copied");
}

function makeid() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 40; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}

function generateKey(){
    var id = makeid();
    var api_key = document.getElementById('api_key');
    var txt_api_key = document.getElementById('txt_api_key');

    api_key.innerHTML = id;
    txt_api_key.value = id;
}
</script>
<style>
    .method{
        color: #039be5;
        font-weight: bold;
    }
    .param{
        color: #ec407a;
        font-weight: bold;
        white-space: nowrap;
    }
    .args{
        max-width: 100%;
        background: #fff;
        border: solid 1px #e1e4e5;
        font-size: 75%;
        padding: 0 3px;
        font-family: Incosolata,Consolata,Monaco,monospace;
        overflow-x: auto;
        color: #000; 
        font-weight: bold;
    }
</style>
<h4 class="title">API Reference</h4>
<p class="subtitle">Relative to the base URI: https://www.example.com/rest/api.php</p>
<table class="table" style="margin-top: 10px">
    <thead>
        <tr>
            <th>Method</th>
            <th>HTTP request</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span class="method">get</span></td>
            <td>GET /product</td>
            <td>List the products.</td>
        </tr>
        <tr>
            <td><span class="method">get</span></td>
            <td>GET /product/<span class="param">id</span></td>
            <td>Gets the specified product.</td>
        </tr>
        <tr>
            <td><span class="method">get</span></td>
            <td>GET /category</td>
            <td>List the categories.</td>
        </tr>
        <tr>
            <td><span class="method">get</span></td>
            <td>GET /category/<span class="param">id</span></td>
            <td>Gets the specified category.</td>
        </tr>
        <tr>
            <td><span class="method">get</span></td>
            <td>GET /bank</td>
            <td>List the banks.</td>
        </tr>
        <tr>
            <td><span class="method">get</span></td>
            <td>GET /bank/<span class="param">id</span></td>
            <td>Gets the specified bank.</td>
        </tr>
        <tr>
            <td><span class="method">get</span></td>
            <td>GET /gallery</td>
            <td>List the galleries</td>
        </tr>
        <tr>
            <td><span class="method">get</span></td>
            <td>GET /gallery/<span class="param">id</span></td>
            <td>Get the specified gallery section.</td>
        </tr>
        <tr>
            <td><span class="method">get</span></td>
            <td>GET /discount</td>
            <td>List the discounts</td>
        </tr>
        <tr>
            <td><span class="method">post</span></td>
            <td>POST /register</td>
            <td>Creates a new customer</td>
        </tr>        
    </tbody>
</table>
<h4 class="title">Headers</h4>

<p class="subtitle">The only permissible content type is JSON at the moment. All requests must include the following header:</p>

<p class="code">Content-Type: application/json</p>
<h4 class="title">Auth Parameter</h4>
<p class="subtitle">To access the API, it must send a <strong>auth parameter</strong></p>

<table class="table" style="margin-top:0">
    <thead>
        <tr>
            <td>key</td>
            <td>value</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>auth</strong></td>
            <td><span class="args">API_KEY</span></td>
        </tr>
    </tbody>
</table>
<p class="code">https://example.com/rest/api.php/<span class='args'>HTTP_REQUEST</span>?auth=<span class='args'>API_KEY</span></p>
<p class="subtitle">if <strong>auth</strong> parameter is not valid will be like this :</p>
<pre class="JSONCode">
<code>
{
    <span class="brown">"status"</span>: false,
    <span class="brown">"message"</span>: <span class="mediumblue">"Invalid API key"</span>
} 
</code>
</pre>
<p class="subtitle">without <strong>auth</strong> parameter or <strong>auth</strong> parameter is empty, will be like this :</p>
<pre class="JSONCode">
<code>
{
    <span class="brown">"status"</span>: false,
    <span class="brown">"message"</span>: <span class="mediumblue">"Missing API key"</span>
} 
</code>
</pre>

<h4 class="title">HTTP Methods</h4>
<p class="subtitle">RESTful APIs enable you to develop any kind of web application having all possible CRUD (create, retrieve, update, delete) operations. REST guidelines suggest you to use specific HTTP method on specific type of call made to server (though technically it is possible to violate this guideline, yet it is highly discouraged).</p>
<table class="table">
    <thead>
        <tr>
            <th>HTTP Methods</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>HTTP GET</td>
        </tr>
            <td>HTTP POST</td>
        </tr>
            <td>HTTP DELETE</td>
        </tr>
        <tr>
            <td>HTTP PATCH</td>
        </tr>
    </tbody>
</table>
<h4 class="title">HTTP GET</h4>
<p class="subtitle">Use GET requests <strong>to retrieve resource representation/information only</strong> – and not to modify it in any way. As GET requests do not change the state of resource, these are said to be safe methods. Additionally, GET APIs should be <strong>idempotent</strong>, which means that making multiple identical requests must produce same result everytime until another API (POST or PUT) has changed the state of resource on server.</p>
<br><p class="subtitle">Examples request URIs : </p>
<p class="code"><strong>GET</strong> https://example.com/rest/api.php/<strong>product</strong></p><br>
<p class="subtitle">A sample get request will be like this :</p>
<pre class="JSONCode">
<code>
{
    <span class="brown">"status"</span>: true,
    <span class="brown">"message"</span>: <span class="mediumblue">"success"</span>,
    <span class="brown">"data"</span>: [
        {
            <span class="brown">"product_id"</span>: <span class="mediumblue">"10"</span>,
            <span class="brown">"category_id"</span>: <span class="mediumblue">"1"</span>,
            <span class="brown">"product_name"</span>: <span class="mediumblue">"Samsung Galaxy S8 Smartphone - Midnight Black [B]"</span>,
            <span class="brown">"product_price"</span>: <span class="mediumblue">"10176000"</span>,
            <span class="brown">"product_description"</span>: <span class="mediumblue">"Samsung Galaxy S8, Hadir dengan layar 5.8 Inch Quad HD+ Super AMOLED yang 
                hampir tanpa sisi serta prosesor Octa-core (4x2.3 GHz &amp; 4x1.7 GHz) yang 
                di dukung 4GB RAM dan 64GB memory internal. Dilengkapi juga dengan kamera depan 
                Dual Pixel 12MP F1.7 &amp; belakang 8MP F1.7, WLAN, Bluetooth v5.0, GPS, 
                NFC &amp; USB."</span>,
            <span class="brown">"discount"</span>: null,
            <span class="brown">"stock"</span>: <span class="mediumblue">"90"</span>,
            <span class="brown">"product_image"</span>: <span class="mediumblue">"p_1514481010_4997.jpg"</span>,
            <span class="brown">"clean_url"</span>: <span class="mediumblue">"samsung-galaxy-s8-smartphone-10.html"</span>
        }
        ...
        ]
}
</code>
</pre>
<p class="code"><strong>GET</strong> https://example.com/rest/api.php/<strong>category</strong>/<strong>1</strong></p>
<p class="subtitle">A sample get request will be like this :</p>
<pre class="JSONCode">
<code>
{
    <span class="brown">"status"</span>: true,
    <span class="brown">"message"</span>: <span class="mediumblue">"success"</span>,
    <span class="brown">"data"</span>: [
        {
            <span class="brown">"category_id"</span>: <span class="mediumblue">"1"</span>,
            <span class="brown">"category_name"</span>: <span class="mediumblue">"Handphone &amp; Tablet"</span>
        }
    ]
}    
</code>
</pre>
<h4 class="title">HTTP POST</h4>
<p class="subtitle">Use POST APIs to create new subordinate resources, e.g. a file is subordinate to a directory containing it or a row is subordinate to a database table. Talking strictly in terms of REST, POST methods are used to create a new resource into the collection of resources.</p>
<p class="code"><strong>POST</strong> https://example.com/rest/api.php/<strong>register</strong></p>
<table class="table" style="margin-top:0">
    <thead>
        <tr>
            <th>key</th>
            <th>value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>auth</strong></td>
            <td><span class="args">API_KEY</span></td>
        </tr>
        <tr>
            <td><strong>name</strong></td>
            <td>string(req’d) - name for the User being created</td>
        </tr>
        <tr>
            <td><strong>email</strong></td>
            <td>string(req’d) - email for the User being created</td>
        </tr>
        <tr>
            <td><strong>password</strong></td>
            <td>string(req’d) - password for the User being created</td>
        </tr>
        <tr>
            <td><strong>phone</strong></td>
            <td>string(req’d) - phone for the User being created</td>
        </tr>
        <tr>
            <td><strong>address</strong></td>
            <td>string(req’d) - address for the User being created</td>
        </tr>
    </tbody>
</table>
