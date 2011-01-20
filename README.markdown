README
------

CouchDB Log Writer for Zend Framework

For logs are nosql database is better than RBMS.

- map functions (all log messages)

        function(doc) {
          emit(doc.priorityName,[doc.timestamp,doc.message, doc.module, doc.controller]);
        }

- map function by priority (save as logger/log_by_prior)

        function(doc) {
          if (doc.priority) {
             emit(doc.priority, [doc.priorityName, doc.timestamp, doc.message, doc.module, doc.controller]);
          }
        }

- map function by timestamp (save as logger/log_by_timestamp) 

        function(doc) {
          if (doc.timestamp) {
             emit(doc.timestamp, [doc.priorityName, doc.message, doc.module, doc.controller]);
          }
        }

-  call by using

        http://127.0.0.1:5984/test-log/_design/log_by_prior/_view/log_by_prior/?key=%22ERR%22

- or using PHP as in example IndexController

