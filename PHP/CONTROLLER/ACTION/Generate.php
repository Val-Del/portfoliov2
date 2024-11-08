<?php
if (isset($_POST['use_tables']) && !empty($_POST['use_tables'])) {
    $managerDirectory = $_POST['managerdir'];
    $classDirectory = $_POST['classdir'];
    $classExt = $_POST['inputClassExt'];
    $managerExt = $_POST['inputManagerExt'];
    
    $selectedTables = $_POST['use_tables'] ?? [];
    $classNames = $_POST['class_names'] ?? [];
    $managerNames = $_POST['manager_names'] ?? [];
    
    foreach ($selectedTables as $table) {
        $className = $classNames[$table];
        $managerName = $managerNames[$table];
        
        $classFileName = $className . $classExt;
        $managerFileName = $managerName . $managerExt;
    
        $primaryKey = createClass($table, $classDirectory, $classFileName, $className);
        createManager($table, $managerFileName, $managerDirectory, $managerName, $primaryKey);
        echo "<p>Generated class: $classFileName and manager: $managerFileName for table: $table</p>";
    }
} else {
    
    $managerDirectory = $classDirectory = getcwd();

    $managerDir = 'PHP/MODEL/MANAGER';
    $classDir = 'PHP/CONTROLLER/CLASSE';
    
    $managerDirectory .= DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $managerDir);
    $classDirectory .= DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $classDir);
    $extensionClass = '.Class.php';
    $extensionManager = 'Manager.Class.php';
    
    echo "<form method='POST' action='?page=Generate' enctype='multipart/form-data'>";
        if (is_dir($managerDirectory)) {
            echo '<h3>Where to create managers</h3>';
            echo '<input type="text" name="managerdir" value="' . $managerDirectory . '">';
        }
        if (is_dir($classDirectory)) {
            echo '<h3>Where to create classes</h3>';
            echo '<input type="text" name="classdir" value="' . $classDirectory . '">';
        }
        echo '<h3>Classes extension</h3>';
        echo '<input type="text" name="inputClassExt" value="' . $extensionClass . '">';
        echo '<p class=example>Example: Categories</p><p class="extClass example">' . $extensionClass . '</p>';
        echo '<h3>Manager extension</h3>';
        echo '<input type="text" name="inputManagerExt" value="' . $extensionManager . '">';
        echo '<p class=example>Example: Categories</p><p class="extManager ext example">' . $extensionManager . '</p>';
        try {
            $db = DbConnect::getDb();
            $tablesQuery = $db->query("SHOW TABLES");
            $i = 0;

            while ($tableRow = $tablesQuery->fetch(PDO::FETCH_NUM)) {
                $tableName = $tableRow[0];
                $class = ($i % 2 == 0) ? 'even' : 'odd';
                
                echo '<div class="tables ' . $class . '">';
                    echo "<input type='checkbox' id='use_$tableName' name='use_tables[]' value='$tableName'>";
                    echo "<label for='use_$tableName'> Use this table</label><br>";
                    echo "<h4>$tableName</h4>";
                    echo "<div class='input-wrapper'>";
                        echo "<input type='text' name='class_names[$tableName]' value='". ucfirst($tableName)."'>";
                        echo "<span no-select class='extClass extension'>$extensionClass</span>";
                    echo "</div><br>";
                    echo "<div class='input-wrapper'>";
                        echo "<input type='text'  name='manager_names[$tableName]' value='".ucfirst($tableName)."'><br>";
                        echo "<span no-select class='extManager extension'>$extensionManager</span>";
                    echo "</div><br>";
                echo '</div>';
                $i++;
            }

            echo "<button type='submit'>Generate</button>";
        echo "</form>";
        
    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }

    echo "
    <style>
        body {
            background-color: #ffffff !important;
            color: #333 !important;
            margin: 0 !important;
            padding: 1rem !important;
        }

        form {
            font-family: Arial, sans-serif !important;
        }

        input[type='text'] {
            width: 100% !important;
            padding: 8px !important;
            margin: 8px 0 !important;
            box-sizing: border-box !important;
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            outline:none !important;
        }
        
        .tables {
            margin-top:2rem !important;
        }

        .example{
            font-style: italic !important;
            font-size: 0.8rem !important;
            color: grey !important;
            display:inline !important;
        }

        .even {
            background-color: #f7f7f7 !important;
            padding: 10px !important;
            border-radius: 4px !important;
        }

        .odd {
            background-color: #f9eae1 !important;
            padding: 10px !important;
            border-radius: 4px !important;
        }

        h3 {
            color: #AB47BC !important;
            margin-top: 1rem !important;
        }

        h4 {
            color: #AB47BC !important;
            font-size: 1.2rem !important;
            margin: 1rem 0 !important;
        }

        button {
            margin-top: 1rem !important;
            background-color: #AB47BC !important;
            color: white !important;
            padding: 10px 20px !important;
            border: none !important;
            cursor: pointer !important;
            border: solid 1px #AB47BC !important;
            transition: all 0.5s !important;
        }

        button:hover {
            background-color: white !important;
            color: #AB47BC !important;
        }
        .input-wrapper {
            position: relative !important;
            display: inline-block !important;
        }

        .input-wrapper input[type=\"text\"] {
            padding-right: 120px !important;
            height: 40px !important;
        }

        .input-wrapper .extension {
            position: absolute !important;
            right: 0 !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: #555 !important;
            pointer-events: none !important;
            background-color: #D3D3D3 !important;
            padding: 0 0.2rem !important;
        }
        .extension {
            line-height: 40px !important;
        }
    </style>";
    echo '<script>
            document.querySelector(\'input[name="inputClassExt"]\').addEventListener(\'input\', function(e) {
                const exts = document.querySelectorAll(\'.extClass\');
                exts.forEach(ext => {
                    ext.innerHTML = e.target.value;
                });
            });
            document.querySelector(\'input[name="inputManagerExt"]\').addEventListener(\'input\', function(e) {
                console.log(e.target.value)
                const exts = document.querySelectorAll(\'.extManager\');
                console.log(exts)
                exts.forEach(ext => {
                    ext.innerHTML = e.target.value;
                });
            });
        </script>';
}
function createClass($tableName, $classDirectory, $classFileName, $className)
{
    $db = DbConnect::getDb();
    $classFilePath = $classDirectory . '/' . $classFileName;

    $classClassName = ucfirst($className); 

    $classFile = fopen($classFilePath, 'w');

    $content = "<?php\n";
    $content .= "class " . $classClassName . "\n{\n";

    $query = $db->query("SHOW COLUMNS FROM $tableName");
    $columns = $query->fetchAll(PDO::FETCH_ASSOC);

    $primaryKey = null;

    foreach ($columns as $column) {
        $columnName = $column['Field'];
        $content .= "    private \$_" . $columnName . ";\n";
        
        if ($column['Key'] === 'PRI') {
            $primaryKey = $columnName;
        }
    }

    $content .= "    private static \$_attributes = [";
    foreach ($columns as $column) {
        $content .= "'" . $column['Field'] . "', ";
    }
    $content = rtrim($content, ', ') . "];\n";

    // Generate accessors (getters and setters)
    $content .= "\n    /** Accessors **/\n";
    foreach ($columns as $column) {
        $columnName = $column['Field'];
        $content .= "    public function get" . ucfirst($columnName) . "()\n    {\n";
        $content .= "        return \$this->_" . $columnName . ";\n";
        $content .= "    }\n";
        $content .= "    public function set" . ucfirst($columnName) . "(\$" . $columnName . ")\n    {\n";
        $content .= "        \$this->_" . $columnName . " = \$" . $columnName . ";\n";
        $content .= "        return \$this;\n";
        $content .= "    }\n\n";
    }

    // Add attributes getter
    $content .= "    public static function getAttributes()\n    {\n";
    $content .= "        return self::\$_attributes;\n";
    $content .= "    }\n";

    // constructor and hydrate function
    $content .= "\n    /** Constructor **/\n";
    $content .= "    public function __construct(array \$options = [])\n    {\n";
    $content .= "        if (!empty(\$options)) {\n";
    $content .= "            \$this->hydrate(\$options);\n";
    $content .= "        }\n";
    $content .= "    }\n";
    $content .= "    public function hydrate(\$data)\n    {\n";
    $content .= "        foreach (\$data as \$key => \$value) {\n";
    $content .= "            \$method = \"set\" . ucfirst(\$key);\n";
    $content .= "            if (is_callable([\$this, \$method])) {\n";
    $content .= "                \$this->\$method(\$value === \"\" ? null : \$value);\n";
    $content .= "            }\n";
    $content .= "        }\n";
    $content .= "    }\n";
    $content .= " }\n";

    fwrite($classFile, $content);
    fclose($classFile);

    return $primaryKey;
}

function createManager($tableName, $managerFileName, $managerDirectory, $managerName, $primaryKey)
{
    // manager file path
    $managerFilePath = $managerDirectory . '/' . $managerFileName;

    // manager name 
    $managerClassName = ucfirst($managerName); 

    // Open the manager file
    $managerFile = fopen($managerFilePath, 'w');

    $content = "<?php\n\n";
    $content .= "class " . $managerClassName . "Manager\n{\n";
    
    // Add method
    $content .= "    public static function add(" . ucfirst($tableName) . " \$obj)\n";
    $content .= "    {\n";
    $content .= "        return DAO::add(\$obj);\n";
    $content .= "    }\n\n";
    
    // Update method
    $content .= "    public static function update(" . ucfirst($tableName) . " \$obj)\n";
    $content .= "    {\n";
    $content .= "        return DAO::update(\$obj);\n";
    $content .= "    }\n\n";
    
    // Delete method
    $content .= "    public static function delete(" . ucfirst($tableName) . " \$obj)\n";
    $content .= "    {\n";
    $content .= "        return DAO::delete(\$obj);\n";
    $content .= "    }\n\n";
    
    // FindById method
    $content .= "    public static function findById(\$id)\n";
    $content .= "    {\n";
    $content .= "        return DAO::select(" . ucfirst($tableName) . "::getAttributes(), \"$tableName\", [\"$primaryKey\" => \$id])[0];\n";
    $content .= "    }\n\n";
    
    // GetList method
    $content .= "    public static function getList(array \$nomColonnes = null, array \$conditions = null, string \$orderBy = null, string \$limit = null, bool \$api = false, bool \$debug = false)\n";
    $content .= "    {\n";
    $content .= "        \$nomColonnes = (\$nomColonnes == null) ? " . ucfirst($tableName) . "::getAttributes() : \$nomColonnes;\n";
    $content .= "        return DAO::select(\$nomColonnes, \"$tableName\", \$conditions, \$orderBy, \$limit, \$api, \$debug);\n";
    $content .= "    }\n";

    $content .= "}\n";

    fwrite($managerFile, $content);
    fclose($managerFile);
}