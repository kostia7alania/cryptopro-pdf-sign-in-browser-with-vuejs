
Vue.component("app-stamp-prev", {
    props: ["doc_prev","stamp_img","stampPrevShow"],
    template: `
        <div>  
            <p v-show="stamp_img.length<1  && doc_prev.length<1 " style="text-align:center"><i class="fa fa-spinner fa-spin" style="font-size:33px"></i></p>
            <div v-show="stamp_img.length>0 && doc_prev.length>0">
                <h3>Положение видимой печати:</h3>  
                <img width="595" height="842" :src="doc_prev" id="watermarked" /> 
                <p>Подтвердить выставленное положение видимой печати</p>
                <button @click="podpis_prev(0)">Подтвердить и подписать</button> 
            </div> 
   </div>`,
    data: function () {return {   } },
    methods: {
        podpis_prev(stamp_prev){//1-prev;0-final
            this.$emit('podpisat-confirm',0);
        }
    },
    updated: function () {this.$nextTick(function () { })}// Code that will run only after the entire view has been re-rendered 
}); 
  
 
Vue.component("app-get-cert-list", {
    template: `
    <div>
        <button class="btn btn-danger" v-if="!certList" @click="getCertList">Получить список сертификатов</button>

        <div v-if="!certList==''"> 
            <h2>Выберите сертификат:</h2>  
            <select  multiple @click="sertSelectHandler">
                <option v-for="(crt,index) in certList" :value="index">{{crt.label}}</option> 
            </select>
        </div>

        <div v-if=" !selected_sert=='' ">
        <h2>Выбран сертификат: </h2>
            issuerName:     {{selected_sert.issuerName}} <br>
            label:          {{selected_sert.label}}  <br>
            name:           {{selected_sert.name}}  <br>
            subjectName:    {{selected_sert.subjectName}} <br> 
            Действителен: с {{selected_sert.validFrom}} по {{selected_sert.validTo}} <br>
        </div>

    </div>`,
    data: function () {
        return { 
            certList: '', 
            selected_sert: '' 
        }
    },
    methods: {
        getCertList(){ // получение списка сертификатов
            var that = this;
            window.CryptoPro.call('getCertsList')
            .then(function (list) { 
                console.log(list); 
                that.certList = list;
                //that.selected_sert = list[0];that.$emit('selecting_sert',list[0]);
            }, function (err) {console.log( this, err ); alert( err );}); 
        },
        getCertBase64(){
            var that = this;
            this.selected_sert._cert.Export(0)
            .then(function(cert64) {
                cert64 = cert64.replace(/\n/gim,'').replace(/\r/gim,'').replace(' ','').trim()
                that.$emit('cert-base64', cert64);
                console.log('cert64=>', cert64);
            })
            .then(
                function(){
                    that.$emit('podpisat-confirm',1)//1-preview,0-final
                }
            )
        },
        sertSelectHandler(e){
            e=e.target.value;
            $('.ui-draggable').remove();
            this.selected_sert = this.certList[e];
            this.$emit('selecting-sert',this.certList[e]);
            this.getCertBase64();  
        }
      }
}); 
 


Vue.component("app-main", { 
    template: `
    <div> 
        <div is="app-get-cert-list"  
            @podpisat-confirm="podpisat_confirm"
            @get-cert-list="getCertList" 
            @selecting-sert="selecting_sert" 
            @cert-base64="certing_base64"
        ></div>

        <div v-show="stampPrevShow" is="app-stamp-prev" class="pechat"
             @podpisat-confirm="podpisat_confirm"
             :doc_prev="doc_prev" 
             :stamp_img="stamp_img"
        ></div>
        <hr> 
        <p>stat: {{stat}}</p> 
        <p>msg: {{msg}}</p>  
        <hr>
        <div v-if="iframe_show">
            <p v-if="base64Binary.length<1" style="text-align:center"><i class="fa fa-spinner fa-spin" style="font-size:33px"></i></p>
            <iframe v-else="base64Binary.length>1" :src="base64Binary" width="790px" height="1290px" frameborder="0"></iframe>
        </div>
        <br>
        <button class="btn btn-warning"  v-if="base64Binary.length>1" width="auto"  target="_blank" @click="openBase64">Открыть подписанный документ</button>
    </div>`,
    data: function () {
        return {   
        stampPrevShow: 0,
        doc_prev:  '', //"http://www.edou.ru/upload/learning/3/res26/AU0gg.XoPWc.Image19.jpg",
        stamp_img: '',//"http://stamp-pro.ru/assets/cache_image/products/161/variant-i1_280x280_5db.png",
        url:    './api_dss.php', 
        hashValue: '',
        cacheObjectId:'',
        createdSign: '', 
        msg: '',
        stat:'',
        base64Binary:'',
        cert_base64:'',
        selected_sert:false, 
        pechat_background:'',
        pechat_pos: {x:0,y:0,w:0,h:0,opacity:0},
        iframe_show: 0,
        need_reload: 1
    }},
    methods: {
        podpisat_confirm(stamp_prev){ stamp_prev!=3?podpisat(this, stamp_prev):this.base64Binary=''; },
        certing_base64(e){this.cert_base64 = e;},
        selecting_sert(e){this.selected_sert=e; console.log('ВЫБРАН=>>>>>>>>>',e); this.need_reload=1; this.base64Binary="";this.doc_prev="";this.stamp_img=""; /*флаг на перезагрузку печати*/},
        getCertList(e){console.log('getCertList handler ==>',e)},
        previewPechat(e){    
            console.log('previewPechat=>',e,'<='); this.pechat_pos=e;
            console.log("842-98-parseInt(e.y)  => "+(842-98-parseInt(e.y)) );
            this.pechat_pos.y = parseInt(842-98-parseInt(e.y));      //дроби не любит ПДФ !онли целое!
            this.pechat_pos.x = parseInt(e.x);
        },
        openBase64(){
            var that = this;
            var w = window.open('about:blank'); 
            setTimeout(function(){ //FireFox seems to require a setTimeout for this to work.
                w.document.body.appendChild(w.document.createElement('iframe')).src = that.base64Binary;
            }, 0);
        },
        hashValueHandler(e){this.hashValue=e.target.value.trim();},
        createSign(stamp_prev){
                var that = this; 
                var thumbprint = that.selected_sert.thumbprint;
                var hashValue = that.hashValue;
                console.log('thumbprint=>'+thumbprint, 'hashValue=>'+hashValue)
                window.CryptoPro.call('signData', thumbprint, hashValue)
                .then(function (createdSign) { 
                        console.log('signature=>',createdSign);
                        that.createdSign = createdSign;
                        podpisat2(that,stamp_prev);
                })
        }
    }
});  

var vm = new Vue({
    el: '#vue',
    data: {},
    methods: { },
    watch: {},
    computed: {},
    mounted: function () {}
})
    
 

      
    function podpisat(that,stamp_prev) {
        if(!stamp_prev){that.stampPrevShow=0;that.iframe_show = 1 }   //отобразить спиннер
        if(stamp_prev){that.stampPrevShow=1; that.iframe_show = 0;}   //скрыть спиннер (отображается iframe)
                        
        var formdata = new FormData()
        formdata.append('cert_base64',   that.cert_base64);
        formdata.append('pechat_pos',    JSON.stringify(that.pechat_pos)); 
        formdata.append('selected_sert', JSON.stringify(that.selected_sert)); 
        axios.post(`${that.url}?action=sign&stage=1&stampGen=`+stamp_prev, formdata)
         .then(function (res) {console.log("stage1=>", res);
            res = res.data; that.stat = res.stat; that.msg = res.msg;
            that.hashValue = res.HashValue;
            that.cacheObjectId = res.СacheObjectId;
//              stamp_prev==1?this.
            that.createSign(stamp_prev);
          }).catch(function (err) { console.log("err=>"+err); that.stat = 0; that.msg = "Error while processing in stage1!"; });
    }
    function podpisat2 (that,stamp_prev) {

        var formdata = new FormData();
        formdata.append('hashValue',    that.hashValue);
        formdata.append('pechat_pos',  JSON.stringify(that.pechat_pos)); 
        formdata.append('cacheObjectId',that.cacheObjectId);
        formdata.append('createdSign',  that.createdSign);    
        formdata.append('selected_sert',JSON.stringify(that.selected_sert));
        axios.post(`${that.url}?action=sign&stage=2&stampGen=`+stamp_prev, formdata)
        .then(function (res) { console.log("stage2=>",  res ); 
            if  ( stamp_prev==1 && that.need_reload==1 ) { 
                try{
                    that.stamp_img = "data:image/png;base64,"+res.data.split('[BREAK]')[0];   //stamp_img
                    that.doc_prev =  "data:image/jpg;base64,"+res.data.split('[BREAK]')[1];   //doc_prev
                }catch(err){console.log("err=>"+err); that.stat = 0; that.msg = "Error while parsing preview stamp!";}
            }
            else{ that.base64Binary = res.data.base64Binary;}
        })
        .then(function(){ 
            if  ( stamp_prev==1 && that.need_reload==1 ) { 
                $('#watermarked').Watermarker({
                    watermark_img: that.stamp_img,  opacity: 1, x:227, y:37, w:236, h:98,
                    onChange: function(e){that.previewPechat(e)}.bind(that) 
                });
            }
            that.need_reload=0;
            if(!stamp_prev){that.stampPrevShow=0;that.iframe_show = 1 }   //отобразить спиннер
            if(stamp_prev){that.stampPrevShow=1; that.iframe_show = 0;}   //скрыть спиннер (отображается iframe)
        })
        .catch(function (err) { console.log("err=>"+err); that.stat = 0; that.msg = "Error while processing in stage2!"; });
    }
  