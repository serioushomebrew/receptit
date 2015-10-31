var Client = {

    /**
     * Simple function that returns complete url with client id
     *
     * @param id of the client
     * @returns {string} with url to connect to api (json)
     */
    getClientUrl : function(id){
        return 'https://frahmework.ah.nl/ah/json/klanten?klantid='+id+'&personalkey=rve67tITSGZb4vJo0CdPcRNlpnM1C14a';
    },

    /**
     * Fetch client from frahmework
     *
     * @param id of the client
     * @returns bool | object
     */
    getClient : function(id){
        $.get(this.getClientUrl(id), function(data){

            if(typeof data[0] == 'undefined'){
                alert('No customer found');
            }else{
                Client.data = data[0];
            }
        });
    }

};
