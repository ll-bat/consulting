# Risk Assessment Consulting Website
### Here is the [demo url](https://test-consulting.herokuapp.com)

## important 
data can be categorized into: `processes`, `dangers`, `controls`, `potential damages` and `who-is-under-danger` groups
- Usually, one `process` includes several dangers 
- Each `danger` can have multiple `controls` 
- Each `process`, `danger`, `control` has `**score**` which will be used during risk evaluation
- `potential damages` and `who-is-under-danger` are independent groups, and they also have scores
- All this data is `field` specific. First, You create a `field` and then - everything for this `field`. You'll choose a field when creating a risk assessment document


#### Document data is represented as a table divided into two parts: header and body 
- header contains document info (such as: name, surname, evaluation date, ...)
- body contains all processes, dangers and some other related things and, most importantly, risk info

### You have an option to export table data as 
- PDF 
- Excel 
- MS Word (_feature is being added_)

# Some Screenshots

### **Creating fields**
![Admin panel](https://raw.githubusercontent.com/ll-bat/consulting/master/public/img/site_schreenshots/admin-panel.png)

### **Inside a field**
![Admin panel](https://raw.githubusercontent.com/ll-bat/consulting/master/public/img/site_schreenshots/inside-field.png)

### **Editing danger**
![Admin panel](https://raw.githubusercontent.com/ll-bat/consulting/master/public/img/site_schreenshots/danger-inner-view.png)

### **Creating document**
![Admin panel](https://raw.githubusercontent.com/ll-bat/consulting/master/public/img/site_schreenshots/creating-document-1.png)
![Admin panel](https://raw.githubusercontent.com/ll-bat/consulting/master/public/img/site_schreenshots/creating-document-2.png)
![Admin panel](https://raw.githubusercontent.com/ll-bat/consulting/master/public/img/site_schreenshots/creating-document-3.png)
![Admin panel](https://raw.githubusercontent.com/ll-bat/consulting/master/public/img/site_schreenshots/creating-document-4.png)
