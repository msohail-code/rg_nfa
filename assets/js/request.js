//document.getElementById('rg_input').value = localStorage.getItem('rg');
    document.getElementById('rg_nfa').addEventListener('submit', function(e) {
       
        e.preventDefault(); 
        let ajax_result = document.getElementById('ajax_output');
        var rg_data = "rg_data="+document.getElementById('rg_input').value;
        
        var get_nfa = new XMLHttpRequest();
        get_nfa.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                
                ajax_result.innerHTML = this.responseText;
                document.getElementById('nfa_diagram').style.display = 'block';
            }
        };
        get_nfa.open('post','process.php',true);
        get_nfa.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        get_nfa.send(rg_data);
    })

    

   function without_epsilon() {
      
        //e.preventDefault(); 
        let ajax_result = document.getElementById('without_epsilon');
        var rg_data = "no_epsilon="+document.getElementById('rg_input').value;
        
        var get_nfa = new XMLHttpRequest();
        get_nfa.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                
                ajax_result.innerHTML = this.responseText;
                document.getElementById('nfa_diagram').style.display = 'block';
            }
        };
        get_nfa.open('post','process.php',true);
        get_nfa.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        get_nfa.send(rg_data);
    }


    document.getElementById('nfa_rg').addEventListener('submit', function(e) {
       
        e.preventDefault(); 
        
        var elements = document.getElementsByClassName("nfa_value");
        var formData = new FormData(); 
        for(var i=0; i<elements.length; i++)
        {
            formData.append(elements[i].name, elements[i].value);
        }
        let ajax_result = document.getElementById('nfa_rg_output');
        var rg_data = "rg_data="+document.getElementById('rg_input').value;
        
        var get_nfa = new XMLHttpRequest();
        get_nfa.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                
                ajax_result.innerHTML = this.responseText;
                document.getElementById('nfa_diagram').style.display = 'block';
            }
        };
        get_nfa.open('post','process.php',true);
        //get_nfa.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        get_nfa.send(formData);
    })

