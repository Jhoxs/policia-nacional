import { Typography, Card, Space } from 'antd';
import collectionColors from '/resources/js/Providers/ColorProvider.js'

const { colorStatusLabel } = collectionColors;
const { Title, Text } = Typography;

const ShiftInfo = ({ maintenance }) => {

    const gridStyle = {
        width: '100%',
        padding: '10px'

    };

    const colorBackground = colorStatusLabel[maintenance.status_label.toUpperCase()];

    return (
        <>
            < Title level={4} style={{ marginLeft: '5px' }}>
                Información del Turno
            </Title >

            <Card style={{ marginTop: '20px', marginRight: '15px' }}>
                <Card.Grid style={{ ...gridStyle, background: colorBackground }} hoverable={false}>
                    <Space size={20} style={{ paddingLeft: '10px' }}>
                        <div className='sm:block'>
                            <div>
                                <Text strong> {maintenance.status_label || ''} </Text>
                            </div>
                            <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Estatus del Turno</div>
                        </div>
                    </Space>
                </Card.Grid>
                <Card.Grid style={gridStyle} hoverable={false}>
                    <Space size={20} style={{ paddingLeft: '10px' }}>
                        <div className='sm:block'>
                            <div>
                                <Text strong> {maintenance.shift_time_range || ''} </Text>
                            </div>
                            <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Horario del Turno</div>
                        </div>
                    </Space>
                </Card.Grid>
                <Card.Grid style={gridStyle} hoverable={false}>
                    <Space size={20} style={{ paddingLeft: '10px' }}>
                        <div className='sm:block'>
                            <div>
                                <Text strong> {maintenance.shift_date || ''} </Text>
                            </div>
                            <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Fecha del Turno</div>
                        </div>
                    </Space>
                </Card.Grid>
                <Card.Grid style={gridStyle} hoverable={false}>
                    <Space size={20} style={{ paddingLeft: '10px' }}>
                        <div className='sm:block'>
                            <div>
                                <Text italic={ maintenance.description ? true : false } strong> {maintenance.description || '<< No existen detalles >>'}</Text>
                            </div>
                            <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Detalles del Turno</div>
                        </div>
                    </Space>
                </Card.Grid>
                {maintenance.status == 1 && (
                    <>
                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={{ paddingLeft: '10px' }}>
                                <div className='sm:block'>
                                    <div>
                                        <Text italic={ maintenance.description ? true : false } strong> {maintenance.reason_reject || 'No existen detalles del rechazo'}</Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Motivos del Rechazo</div>
                                </div>
                            </Space>
                        </Card.Grid>
                    </>
                )}
            </Card>
        </>

    )

}

export default ShiftInfo;