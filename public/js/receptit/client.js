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
    },

    /**
     * Get the shopping list of a client
     *
     * @param clientId of the client
     */
    getShoppingList : function(clientId){
        var url = 'https://frahmework.ah.nl/ah/json/voedingswaardebon?klantid=13555&personalkey=rve67tITSGZb4vJo0CdPcRNlpnM1C14a';

        $.get(url, function(data){
            if(typeof data[0] == 'undefined'){
                alert('No shopping list found');
            }else{
                Client.shopping = data[0];
            }
        });
    }

};
