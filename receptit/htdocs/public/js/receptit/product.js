var Product = {
    getByNasaNr : function(nasanr, cb){
        var url = 'https://frahmework.ah.nl/ah/json/producten?nasanr='+nasanr+'&personalkey=rve67tITSGZb4vJo0CdPcRNlpnM1C14a';
        $.get(url,function(data){
            cb(data);
        })
    }
};