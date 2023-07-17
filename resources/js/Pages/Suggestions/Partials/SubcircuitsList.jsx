import { Card, Row, Col, Button, Space, message, Popconfirm, Tag, Typography, Tooltip, Input, DatePicker, Radio } from 'antd';
import { EditOutlined, DeleteOutlined, QuestionCircleOutlined, SearchOutlined } from '@ant-design/icons';
import collectionColors from '/resources/js/Providers/ColorProvider.js'
import { useState } from 'react';
import { usePage, router, Link } from '@inertiajs/react';
import PaginatedTable from '@/Components/PaginatedTable';
import dayjs from 'dayjs';

const { Title } = Typography;
const { colorVehicles } = collectionColors;
const { RangePicker } = DatePicker;

const SubcircuitsList = ({ subcList }) => {


    const subcListNew = {
        data: subcList?.data,
        meta: {
            ...subcList
        }
    }

    const { permissions } = usePage().props?.auth || [];
    const { filters } = usePage().props;

    const [searchItemValue, setSearchItemValue] = useState({
        value: 'plate',
        label: 'Placa'
    });
    
    const [filterItemValue, setFilterItemValue] = useState(filters.filter || 'all');
    const [searchValue, setSearchValue] = useState(filters.value);
    const [searchDate, setSearchDate] = useState([]);

    const confirm = data => e => {
        router.delete(route('subvehicle.destroy', data), {
            onSuccess: () => {
                message.success('Se ha eliminado el subcircuito con éxito');
            }
        });
    }
    const cancel = (e) => {
        message.warning('Se canceló esa acción');
    }

    const columns = [
        {
            title: 'Fecha de Inicio',
            dataIndex: 'from_date',
            key: 'from_date',
            width: '10%',
        },
        {
            title: 'Fecha de Fin',
            dataIndex: 'to_date',
            key: 'to_date',
            width: '10%',
        },
        {
            title: 'Total de Información',
            dataIndex: 'total',
            key: 'total',
            width: '10%',
        },
        {
            title: 'Tipo se Solicitud',
            dataIndex: 'tipo',
            key: 'tipo',
            width: '10%',
        },
        {
            title: 'Circuito',
            dataIndex: 'circuito',
            key: 'circuito',
            width: '10%',
        },
        {
            title: 'Subcircuito',
            dataIndex: 'subcircuito',
            key: 'subcircuito',
            width: '10%',
        },

    ];

    const options = [
        {
            label: 'Placa',
            value: 'plate'
        },
        {
            label: 'Marca',
            value: 'brand'
        },
        {
            label: 'Tipo de Vehículo',
            value: 'vehicle_type'
        },
        {
            label: 'Subcircuitos',
            value: 'subcircuit'
        },
    ];


    const handleSeach = (value, itemValue) => {
        const iValue = itemValue.value || itemValue;
        router.visit(route('subvehicle.index', { value: value, key: iValue }), {
            preserveState: true,
            preserveScroll: true,
            method: 'get'
        })
    }

    
    const handleFilter = (e) => {
        setFilterItemValue(e.target.value);
        router.visit(route('suggestion.index', { filter: e.target.value, filterDate: searchDate }), {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            method: 'get'
        })
    }
    
    const changeDate = (date, dateString) => {
        if(dateString[0] == ''){
            //setSearchDate([dayjs().format('YYYY-MM-DD'),dayjs().format('YYYY-MM-DD')]);
            setSearchDate([]);
            handleResetFilterDate();
        }else{
            setSearchDate(dateString);
        }          
    }

    

    const handleFilterDate = () => {
        router.visit(route('suggestion.index', { filterDate: searchDate, filter:filterItemValue}), {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            method: 'get'
        })
    }

    const handleResetFilterDate = () => {
        router.visit(route('suggestion.index', { filterDate: [], filter:filterItemValue }), {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            method: 'get'
        })
    }
    
    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Detalles
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <div className="flex justify-end mb-5">
                <Space direction="vertical">
                    {/* <Space wrap>
                        Búsqueda por fechas
                    </Space> */}
                    <Space wrap>
                        <RangePicker
                            size='large'
                            disabledDate={(current) => {
                                return current && current.valueOf() > Date.now();
                            }}
                            placeholder={['Fecha de inicio', 'Fecha de fin']}
                            format={'YYYY-MM-DD'}
                            onChange={changeDate}
                            //value={[dayjs(searchDate[0]) || '',dayjs(searchDate[1])|| '']}
                        />

                        <Tooltip title="Buscar">
                            <Button
                                shape="circle"
                                icon={<SearchOutlined />}
                                onClick={handleFilterDate}
                                disabled={(searchDate.length < 1) || (searchDate.length && searchDate[0] == '')}
                            />
                        </Tooltip>
                        {/* <Tooltip title="Reiniciar Fecha">
                            <Button
                                icon={<DeleteOutlined />}
                                onClick={handleResetFilterDate}
                            />
                        </Tooltip> */}
                    </Space>


                </Space>
            </div>
            {/* <div className="flex justify-end mb-3 ">
                <Space.Compact size='large'>
                    <Select
                        options={options}
                        defaultValue={options[0]}
                        onChange={value => setSearchItemValue(value)}
                    />
                    <Input.Search
                        value={searchValue}
                        onChange={e => setSearchValue(e.target.value)}
                        onSearch={value => handleSeach(value, searchItemValue)}
                    />
                </Space.Compact>
            </div> */}
            <div className="flex justify-end mb-3">
                <Radio.Group size='small' defaultValue={filterItemValue} onChange={handleFilter}>
                    <Radio.Button value={'all'}> Todos </Radio.Button>
                    <Radio.Button value={'sugg'}> Sugerencia </Radio.Button>
                    <Radio.Button value={'reclaim'}> Reclamo</Radio.Button>
                </Radio.Group>
            </div>

            <PaginatedTable
                columns={columns}
                dataTable={subcListNew}
            ></PaginatedTable>

        </>
    );
}

export default SubcircuitsList