Selected tags:
<span ng-repeat="tag in search_arguments.tags" >
    <button ng-click="removeSearchArgumentsTag($index)"><%tag%></button>
</span>

<input type="text" ng-model="search_arguments.text" placeholder="text">
<button ng-click="searchImage()"> search</button>

<h3>search tag</h3>
<ul ng-repeat="main_item in keywords">
    <li>
        <%main_item.title%>
    </li>
    <ul>
        <li ng-repeat="level1_item in main_item.level1">
            <%level1_item.title%>
            <ul>
                <li ng-repeat="level2_item in level1_item.level2">
                   <button ng-click = 'appendSearchArgumentsTag(level2_item)'><%level2_item%> </button>
                </li>
            </ul>
        </li>
    </ul>
</ul>