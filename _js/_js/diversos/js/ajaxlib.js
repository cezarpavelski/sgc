/* $Id: ajaxlib.js,v 1.5 2006/07/01 11:12:38 beboom Exp $

############################################################################
#    Copyright (C) 2006 by Igor Garcia <boo@php.net>                       #
#    Translated to english by Marcio Merlone <mmerlone@gmail.com>          #
#                                                                          #
#    This program is free software; you can redistribute it and/or modify  #
#    it under the terms of the GNU General Public License as published by  #
#    the Free Software Foundation; either version 2 of the License, or     #
#    (at your option) any later version.                                   #
#                                                                          #
#    This program is distributed in the hope that it will be useful,       #
#    but WITHOUT ANY WARRANTY; without even the implied warranty of        #
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         #
#    GNU General Public License for more details.                          #
#                                                                          #
#    You should have received a copy of the GNU General Public License     #
#    along with this program; if not, write to the                         #
#    Free Software Foundation, Inc.,                                       #
#    59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.             #
############################################################################

/** Ajax Class                                                          <br>
  *
  * This class abstracts the Ajax technology fundamental concepts with wich
  * is possible to establish a conection between the browser and the server.
  * Thus, it is possible to dinamically update a page contents on the browser
  * without the need to update the whole page.
  */
function Ajax()
{
  var http                  =     null;//!< obj. XMLHttpRequest instance
  var timeout               =     null;//!< Timeout counter
  this.ajax_timeout         =  10*1000;//!< Default timeout (10 seconds)
  this.ajax_timeout_handler =     null;//!< Callback function for timeout
  this.ajax_receive_handler =     null;//!< Callback function for data reception
  this.ajax_method          =    'GET';//!< Default request method
  this.ajax_async           =     true;//!< Assync/synchronous data transfer
  this.ajax_auth_user       =     null;//!< user for http-based auth
  this.ajax_auth_passwd     =     null;//!< password for http-based auth
  this.ajax_input           =       '';//!< Data to be sent to the server
  this.ajax_output          =       '';//!< Data to be received from the server
  this.ajax_response_type   =   'TEXT';//!< Receiving data format (TEXT or XML)
  this.ajax_do_cache        =    false;//!< Allow broser cache or not
  this.ajax_last_errn       =        0;//!< Last error code
  this.ajax_last_err        =       '';//!< Last error description

  /** Instatiates the XMLHttpRequest object
    *
    * @return XMLHttpRequest object or NULL if error or
    *         not supported by the browser
    */
  this.create = function() 
  {
    try { return new XMLHttpRequest();                   } catch (e) {}
    try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {}
    try { return new ActiveXObject("Msxml2.XMLHTTP");    } catch (e) {}
    return null;
  }

  /** Returns the last response the XMLHttpRequest object got.
    *
    * @return the last responseText/responseXML data
    *        (depends on ajax_response_type setting)
    * @see ajax_response_type
    */
  this.get_output = function ()
  {
    return this.ajax_output;
  }

  /** Returns all URI parameters for the request
    * (i.e. ?parametro1=valor1&parametro2=valor2&parametroN=valorN)
    * These parameters are set using the add_input() method.
    *
    * @return all URI parameters for the request given by the user 
    *         when calling the class
    * @see add_input()
    */
  this.get_input = function ()
  {
    return this.ajax_input;
  }

  /** Obtains all necessary POST parameters to assemble the request
    * before we can call the send() method.
    *
    * @param param - parameter name
    * @param val   - parameter value
    * @return - String with the formatted URI with the givem parameters so far
    *           with the add_input() method
    * @see add_input()
    * @see send()
    */
  this.add_input = function(param, val)
  {
    if (!param || param == '') return false;
    this.ajax_input += (this.ajax_input == '') ? '' : '&';
    this.ajax_input += (param+'='+encodeURIComponent(val));
    return this.ajax_input;
  }

  /**  Returns the XMLHttpRequest object.
    *  used only by this class. 
    *  Used while waiting for the status change (onreadystatechange).
    *
    *  @return a pointer to a instance of XMLHttpRequest object
    */
  this.get_ajax = function() 
  {
    return http;   
  }

  /** This method implements a fast way to send all elements in the form to 
    * the server-side script.
    * The add_input() method will be called to each element in the form (so
    * you don't need to call add_input() before perform the send()) and then
    * call the send() method.
    *
    * @param url - Script URL to handle the request on the server
    * @param frm - (OPTIONAL) Send only the elements in the form named 'frm'.
    *              This arguments accepts numeric index, too.
    * @return TRUE on success or FALSE otherwise.
    */
  this.send_all = function(url)
  {
    var q = n = v = t = d = l = new String();
    // Get all FORM elements...
    var fa = document.getElementsByTagName('FORM');
    // Get the optional argument...
    var fname = arguments[1];

    for (var x=0; x<fa.length; x++)
    {
      // Get the form elements array...
      e = document.forms[x].elements;

      // If 'frm' is set, then skip other forms...
      if (fname != "" && fname != undefined && fname != null)
      {
        if (document.forms[x] != document.forms[fname]) continue;
      }

      // Grab each element in elements array...
      for (var i=0; i<e.length; i++)
      {
        n = e[i].name;
        t = e[i].type;

        // If it don't have a name/type, then it don't have a future in this world !
        if (n == "" || n == undefined) continue;
        if (t == "" || t == undefined) continue;

        // If the element is a SELECT MULTIPLE, get all selected itens...
        if (t.toUpperCase() == 'SELECT-MULTIPLE')
        {
          for (var se=0; se<e[i].length; se++)
          {
            if (e[i][se].selected)
              this.add_input(n, e[i][se].value);
          }
          continue;
        }

        // If element is a radio button, grab only the checked radio...
        if (t.toUpperCase() == 'RADIO')
        {
          if (e[i].checked == true)
          {
            this.add_input(n, e[i].value);
          }
          continue;
        }

        // If element is a checkbox, grab only the checked boxes...
        if (t.toUpperCase() == 'CHECKBOX')
        {
          if (e[i].checked)
          {
            this.add_input(n, e[i].value);
          }
          continue;
        }

        // Grab other type of elements...
        this.add_input(n, e[i].value);
      }
    }

    // If post method is GET, then append the arguments in URL
    if (this.get_method().toUpperCase() == 'GET') url = url+"?"+this.get_input();

    // call the send() function...
    this.send(url);

    // Get out of here with a wonderful success response: TRUE !!! :)
    return true;
  }

  /** Issues the request to the server.
    * You can get/set many aspects of the request by means of set_* / get_* 
    * methods within this class.
    * You should usually call this method after the 'add_input' method 
    * when 'ajax_method' is POST.
    * When using GET it is best to use synchronous calls and wait for the answer.
    * @param url - Script URL to handle the request on the server
    * @return TRUE on success or FALSE if no callback function is defined AND 
    *          errors are detected. Por fim, caso nao tenha uma função de 
    *          callback definida para tratar as respostas do servidor e 
    */
  this.send = function(url)
  {
    // Opens the conection with the server...
    http.open(this.ajax_method, url, this.ajax_async,
                   this.ajax_auth_user, this.ajax_auth_passwd);

    // Set the charset to talk with...
    http.setRequestHeader("Accept-Charset","iso-8859-1;q=1");

    // Sets wheter to use cache or not...
    if (!this.ajax_do_cache && this.ajax_method.toUpperCase() == 'GET')
    {
      http.setRequestHeader("If-Modified-Since","Thu, 5 Feb 1981 20:00:00 GMT");
    }

    // Sets the request method to be used...
    if (this.ajax_method.toUpperCase() == 'POST')
    {
      http.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    }

    // Check what to do if timeout...
    if (this.ajax_timeout_handler != null)
    {
      // and if we have a callback function use it.
      timeout = setTimeout(this.ajax_timeout_handler, this.ajax_timeout);
    }
    else
    {
      // otherwise abort the request.
      timeout = setTimeout(function(){ http.abort(); }, this.ajax_timeout);
    }

    // Make a synchronous call
    if (!this.ajax_async)
    {
       http.send(this.ajax_input);
       this.ajax_output = (this.ajax_response_type.toUpperCase() == 'XML') ?
                            http.responseXML :
                            http.responseText;
       clearTimeout(timeout);
       return this.ajax_output;
    }

    // If we got here so we have an assynchronous call

    // Sets the callback function to handle the returned data.
    var restype    = this.ajax_response_type;
    var rechandler = this.ajax_receive_handler;
    http.onreadystatechange = function() 
    {
      if (http.readyState != 4) { return; }

      if (http.status != 200)
      {
        this.ajax_last_errn = http.status;
        this.ajax_last_err  = http.statusText;
        http.abort();
        return false;
      }
      else 
      {
        this.ajax_last_errn = 0; 
        this.ajax_last_err  = ''; 
        this.ajax_output    = (restype.toUpperCase() == 'XML') ?
                               http.responseXML :
                               http.responseText;
        clearTimeout(timeout);
        if (rechandler != null) rechandler(this.ajax_output);
      }
    }

    if (this.ajax_input != '') 
    {
      http.send(this.ajax_input);
    }
    else 
    {
      http.send(null);
    }

    return true;
  }

  /** Get if cache will be used or not
    *
    * @return TRUE if cache is to be used or FALSE otherwise
    */
  this.get_cache = function() 
  {
    return this.ajax_do_cache;
  }

  /** Sets if cache will be used or not (default: false)
    *
    * @param c - boolean, sets wheter use cache or not (true|false)
    * @return TRUE if cache is to be used or FALSE otherwise
    */
  this.set_cache = function(c) 
  {
    return (this.ajax_do_cache = c);
  }

  /** Get the type of response from server (TEXT|XML).
    *
    * @return the return type from the server (TEXT|XML)
    */
  this.get_response_type = function()
  {
    return this.ajax_response_type;
  }

  /** Sets the return-type of the data to be give back from the server,
    * in other words, defines how the answer will be parsed (plain text or XML).
    *
    * @param t - return-type (TEXT | XML)
    * @return return-type (TEXT | XML)
    */
  this.set_response_type = function(t) 
  {
    if (t.toUpperCase() != 'TEXT' && t.toUpperCase() != 'XML') 
    {
      return this.ajax_response_type;
    }
    return (this.ajax_response_type = t);
  }


  /** Get the password to be used on the connection
    *
    * @return plain text password as defined on the 'set_auth_pass' method
    */
  this.get_auth_pass = function() 
  {
    return this.ajax_auth_passwd;
  }

  /** Sets the password for http-based authentication, if required by the server
    *
    * @param p - the plain-text password
    * @return the plain-text password
    */
  this.set_auth_pass = function(p) 
  {
    if (!p) return this.ajax_auth_passwd;
    return (this.ajax_auth_passwd = p);
  }

  /** Get the user for http-authentication, if required by the server
    *
    * @return user as defined by the 'set_auth_user' method
    */
  this.get_auth_user = function() 
  {
    return this.ajax_auth_user;
  }

  /** Sets the user for http-based authentication, if required by the server
    *
    * @param u - username to be used
    * @return username as defined here
    */
  this.set_auth_user = function(u) 
  {
    if (!u) return this.ajax_auth_user;
    return (this.ajax_auth_user = u);
  }

  /** Get the assynchronous (true) value for the object (false if synchronous)
    *
    * @return true if assynchronous or false if synchronous
    */
  this.get_async = function() 
  {
    return this.ajax_async;
  }

  /** Sets if synchronous or assynchronous request should be made
    *
    * @param a - true if assynchronous or false if synchronous (default: true)
    * @return true if assynchronous or false if synchronous
    */
  this.set_async = function(a) 
  {
    return (this.ajax_async = a);
  }

  /** Get the request method to be used (POST or GET) 
    *
    * @return the request method
    */
  this.get_method = function() 
  {
    return this.ajax_method;
  }

  /** Sets the request method to be used (POST or GET) 
    *
    * @param m - String indicates the request method (POST | GET)
    * @return the request method
    */
  this.set_method = function(m) 
  {
    if (!m) return this.ajax_method;
    return (this.ajax_method = m.toUpperCase());
  }

  /** Sets the time in seconds to wait for the server answer before abort the 
    * XMLHttpRequest request.
    *
    * @param t - time in seconds
    * @return time in seconds or null on failure
    */
  this.set_timeout = function(t) 
  {
    return ((!isNaN(t)) ? (this.ajax_timeout = t * 1000) : null);
  }

  /** Get the time in seconds to wait for the server answer before abort 
    * the XMLHttpRequest request.
    *
    * @return integer - the number of seconds to wait for the answer
    */
  this.get_timeout = function() 
  {
    return this.ajax_timeout;
  }

  /** Get the callback function name to be used to parse the request answer
    *
    * @return string with the callback function name OR array with the 
    * callback funtion name
    * and its parameters
    */
  this.get_receive_handler = function() 
  {
    return this.ajax_receive_handler;
  }

  /** Sets the callback function name to parse the request answer
    *
    * @param c - a string with the callback function name OR array with the 
    *            callback funtion name and its parameters
    * @return string with the callback function name OR array with the 
    *         callback funtion name and its parameters
    */
  this.set_receive_handler = function(c) 
  {
    if (!c) c = null;
    return (this.ajax_receive_handler = c);
  }

  /** Get the callback function name to handle a request timeout
    *
    * @return string with the callback function name
    */
  this.get_timeout_handler = function() 
  {
    return this.ajax_timeout_handler;
  }

  /** Sets the callback function name to handle a request timeout
    *
    * @return string with the callback function name
    */
  this.set_timeout_handler = function(c) 
  {
    return (this.ajax_timeout_handler = c);
  }

  /** Get the timeout counter
    *
    * @return a pointer to the timeout counter
    */
  this.get_timeout_obj = function() 
  {
    return timeout;
  }

  //===========================================================================

  // Instantiates the XMLHttpRequest object for internal use
  http = this.create(); // instatiates the XMLHttpRequest object

  // If the browser fails to create the object it does not supports ajax.
  if (http == null) alert("Your browser doesn't support AJAX, sorry.");
}
