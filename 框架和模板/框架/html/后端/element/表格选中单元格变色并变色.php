<?php $this->load->view("common/breadcrumb"); ?>
<?php //$this->load->view("app/mod_query"); ?>

    <div id="apiderdata">
            <div>
<!--                <el-table :data="tableData" :span-method="arraySpanMethod" :cell-class-name='getCellIndex'   border @cell-dblclick="cellDblclick" style="width: 100%">-->
                                <el-table :data="tableData" :span-method="arraySpanMethod" :cell-class-name='getCellIndex' :cell-style="setCellStyle"  border @cell-dblclick="cellDblclick" style="width: 100%">
                    <el-table-column prop="id" label="ID" width="180">
                    </el-table-column>
                    <el-table-column prop="name" label="姓名">
                    </el-table-column>
                    <el-table-column prop="amount1" sortable label="数值 1">
                    </el-table-column>
                    <el-table-column prop="amount2" sortable label="数值 2">
                    </el-table-column>
                    <el-table-column prop="amount3" sortable label="数值 3">
                    </el-table-column>
                </el-table>

                <el-table :data="tableData" :span-method="objectSpanMethod" border @cell-dblclick="cellDblclick" style="width: 100%; margin-top: 20px">
                    <el-table-column prop="id" label="ID" width="180">
                    </el-table-column>
                    <el-table-column prop="name" label="姓名">
                    </el-table-column>
                    <el-table-column prop="amount1" label="数值 1（元）">
                    </el-table-column>
                    <el-table-column prop="amount2" label="数值 2（元）">
                    </el-table-column>
                    <el-table-column prop="amount3" label="数值 3（元）">
                    </el-table-column>
                </el-table>
            </div>
    </div>

<script>
    var app = new Vue({
        el: '#apiderdata',
        data: {
            arrayRowColumIndex:[],
            tableData: [{
                id: '12987122',
                name: '王小虎',
                amount1: '234',
                amount2: '3.2',
                amount3: 10
            }, {
                id: '12987123',
                name: '王小虎',
                amount1: '165',
                amount2: '4.43',
                amount3: 12
            }, {
                id: '12987124',
                name: '王小虎',
                amount1: '324',
                amount2: '1.9',
                amount3: 9
            }, {
                id: '12987125',
                name: '王小虎',
                amount1: '621',
                amount2: '2.2',
                amount3: 17
            }, {
                id: '12987126',
                name: '王小虎',
                amount1: '539',
                amount2: '4.1',
                amount3: 15
            }]
        },
        methods: {
            // 控制合并单元格
            // objectSpanMethod({ row, column, rowIndex, columnIndex }) {
            //     if ([0,1].includes(columnIndex)) {
            //         const _row = this.combineRowSpan[rowIndex];
            //         const _col = _row > 0 ? 1 : 0;
            //         return {
            //             rowspan: _row,
            //             colspan: _col
            //         };
            //     }
            // },
            // arraySpanMethod({ row, column, rowIndex, columnIndex }) {
            //     if (rowIndex % 2 === 0) {
            //         if (columnIndex === 0) {
            //             return [1, 3];
            //         } else if (columnIndex === 1 || columnIndex === 2) {
            //             return [0, 0];
            //         }
            //     }
            //     // this.rowspan();
            // },
            objectSpanMethod({ row, column, rowIndex, columnIndex }) {
                if (columnIndex === 0) {
                    if (rowIndex % 2 === 0) {
                        return {
                            rowspan: 2,
                            colspan: 1
                        };
                    } else {
                        return {
                            rowspan: 0,
                            colspan: 0
                        };
                    }
                }
            },
            cellDblclick:function(row, column, cell, event){
                var list = {id: row.index+1,
                    name: '姓名-'+(row.index+1),
                    amount1: '数值1-'+(row.index+1),
                    amount2: '数值2-'+(row.index+1),
                    amount3: '数值3-'+(row.index+1)};
                console.log(row);
                console.log(column);
                console.log(cell);
                console.log(event);
                // this.tableData.push(list);
                this.tableData.splice(row.index+1,0,list);
                this.rowIndex = row.index;
                this.columnIndex = column.index;
            },
            arraySpanMethod({ row, column, rowIndex, columnIndex }) {
                if (rowIndex === this.rowIndex && columnIndex === this.columnIndex) {
                    return {
                        rowspan: 2,
                        colspan: 1
                    };
                }
                if (rowIndex === this.rowIndex+1 && columnIndex === this.columnIndex) {
                    return {
                        rowspan: 0,
                        colspan: 0
                    };
                }
            },
            getCellIndex: function ({ row, column, rowIndex, columnIndex }) {
                row.index = rowIndex;
                column.index = columnIndex;
            },
            setCellStyle: function ({ row, column, rowIndex, columnIndex }) {
                // console.log(rowIndex);
                // console.log(columnIndex);
                /*  选中当前单元格和保存的单元格 */
                if ((rowIndex === this.rowIndex && columnIndex === this.columnIndex) || (this.arrayRowColumIndex.includes(rowIndex+"-"+columnIndex))) {
                    /*  获取当前选中的数据   使用数组保存 */
                    var rowColumIndex=this.rowIndex+"-"+this.columnIndex;
                    this.arrayRowColumIndex.push(rowColumIndex);
                    return { "background-color": "#009221" };
                }
            },
        }
    });
</script>

