
import { registerBlockType } from '@wordpress/blocks'
import {useBlockProps} from '@wordpress/block-editor'
import {useSelect, useDispatch} from '@wordpress/data'

registerBlockType('fsdhh/happy-hour', {
  edit({attributes, setAttributes, context}){

    const blockProps = useBlockProps();

    const  {happy_hour_times} = useSelect(select => {

      return select('core/editor').getEditedPostAttribute('meta')
      
    })

    const { editPost } = useDispatch('core/editor')

    console.log(happy_hour_times)


    const handleClear = () => {
      editPost({
        meta: {
          happy_hour_times: {
            sunday: {},
            monday: {},
            tuesday: {},
            wednesday: {},
            thursday: {},
            friday: {},
            saturday: {}
          }
        }
      })
    }

    const handleStartTimeChange = (day, val) => {
      console.log(val)
      editPost({
        meta:{
          happy_hour_times: {
            ...happy_hour_times,
            [day]: {
              end: happy_hour_times[day].end,
              start: val
            }
          }
        }
      })
    }

    const handleEndTimeChange = (day, val) => {
      console.log(val)
      editPost({
        meta:{
          happy_hour_times: {
            ...happy_hour_times,
            [day]: {
              start: happy_hour_times[day].start,
              end: val
            }
          }
        }
      })
    }

    return (
      <div {...blockProps}>
        <h3>Happy Hour Schedule</h3>
        <hr />
        {happy_hour_times.hasOwnProperty('sunday') ? (
          <>
            <div style={{display: "grid", gridTemplateColumns: "1fr 1fr 1fr"}}>
            <div>Day</div>
            <div>Start</div>
            <div>End</div>
            {Object.entries(happy_hour_times)?.map(([day, times]) => (
              <>
              <div>{day}</div>
              <div>
                <input 
                  name="start"
                  type="time" 
                  value={times.start}
                  onChange={e => {
                    handleStartTimeChange(day, e.target.value)
                  }}
                />
              </div>
              <div>
                <input 
                  name="end"
                  type="time" 
                  value={times.end}
                  onChange={e => {
                    handleEndTimeChange(day, e.target.value)
                  }}
                />
              </div>
              </>
            ))}

          </div>
          <button onClick={handleClear}>Clear All</button>  
          </>

        ): (
          <button onClick={handleClear}>Add Timeslots</button>
        )}
        
      </div>
    )
  },
  save(){
    return null
  }
})